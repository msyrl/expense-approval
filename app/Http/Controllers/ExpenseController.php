<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseStoreRequest;
use App\Models\ApprovalSetting;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-expenses');

        $expenses = Expense::with(['source', 'category', 'approvals.approval_status', 'approvals.user']);

        if (request()->filled('q')) {
            $expenses = $expenses->where(function ($query) {
                $q = request()->get('q');

                return $query
                    ->where('recipient', 'LIKE', "%{$q}%")
                    ->orWhere('amount', 'LIKE', "%{$q}%");
            });
        }

        $expenses = $expenses->getPaginate();

        return view('expenses.index', [
            'expenses' => $expenses,
            'sortables' => (new Expense)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-expenses');

        return view('expenses.create', [
            'sources' => Source::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $expense = Expense::create($request->validated());

            $approval_settings = ApprovalSetting::whereAmount($expense->amount)->first();

            if ($approval_settings && $approval_settings->guarantors->count()) {
                $userIDs = $approval_settings->guarantors->pluck('id')->all();

                $expense->createApprovals($userIDs);
            }

            return redirect()
                ->route('expenses.show', $expense)
                ->with('success', 'Success created new data.');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        $this->authorize('access-expenses');

        $expense->load(['approvals.approval_status', 'approvals.user', 'source', 'category']);

        return view('expenses.show', [
            'expense' => $expense,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $this->authorize('edit-expenses');

        $expense->load(['source', 'category']);

        return view('expenses.edit', [
            'sources' => Source::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('name', 'asc')->get(),
            'expense' => $expense,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseStoreRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseStoreRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return redirect()
            ->route('expenses.show', $expense)
            ->with('success', 'Success updated the data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete-expenses');

        if ($expense->hasResponded()) {
            return back()->with('error', 'Can\'t delete responded data.');
        }

        $expense->approvals()->delete();

        $expense->delete();

        return redirect()
            ->route('expenses.index', [
                'sort_by' => 'created_at|desc',
            ])
            ->with('success', 'Success deleted the data.');
    }
}
