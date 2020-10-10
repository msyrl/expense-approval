<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseStoreRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('access-expenses'), 401);

        $collection = Expense::with(['category']);

        if (request()->filled('q')) {
            $collection = $collection->where(function ($query) {
                $q = request()->get('q');

                return $query
                    ->where('recipient', 'LIKE', "%{$q}%")
                    ->orWhere('amount', 'LIKE', "%{$q}%");
            });
        }

        if (request()->filled('sort_by')) {
            $collection = $collection->withSortables();
        } else {
            $collection = $collection->latest();
        }

        $collection = $collection
            ->paginate(request()->get('per_page', 10))
            ->onEachSide(1)
            ->withQueryString();

        return view('expenses.index', [
            'collection' => $collection,
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
        abort_if(Gate::denies('create-expenses'), 401);

        return view('expenses.create', [
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
        $expense = Expense::create($request->validated());

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('expenses.show', $expense->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        abort_if(Gate::denies('access-expenses'), 401);

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
        abort_if(Gate::denies('edit-expenses'), 401);

        return view('expenses.edit', [
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

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('expenses.show', $expense->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('delete-expenses'), 401);

        $expense->delete();

        request()->session()->flash('alert-success', 'Success deleted the data.');

        return back();
    }
}
