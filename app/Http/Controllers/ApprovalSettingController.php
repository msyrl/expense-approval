<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalSettingStoreRequest;
use App\Models\ApprovalSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApprovalSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('access-approval-settings'), 401);

        $collection = ApprovalSetting::with(['guarantors']);

        if (request()->filled('q')) {

            $collection = $collection->where(function ($query) {
                $q = request()->get('q');

                return $query
                    ->where('from_amount', 'LIKE', "%{$q}%")
                    ->orWhere('to_amount', 'LIKE', "%{$q}%");
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

        return view('approval-settings.index', [
            'collection' => $collection,
            'sortables' => (new ApprovalSetting)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('create-approval-settings'), 401);

        return view('approval-settings.create', [
            'users' => User::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ApprovalSettingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApprovalSettingStoreRequest $request)
    {
        $approval_setting = ApprovalSetting::create($request->only([
            'from_amount',
            'to_amount',
        ]));

        $approval_setting->guarantors()->attach($request->users);

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('approval-settings.show', $approval_setting->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalSetting $approval_setting)
    {
        abort_if(Gate::denies('access-approval-settings'), 401);

        $approval_setting->load(['guarantors']);

        return view('approval-settings.show', [
            'approval_setting' => $approval_setting,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalSetting $approval_setting)
    {
        abort_if(Gate::denies('edit-approval-settings'), 401);

        $approval_setting->load(['guarantors']);

        return view('approval-settings.edit', [
            'approval_setting' => $approval_setting,
            'users' => User::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ApprovalSettingStoreRequest  $request
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function update(ApprovalSettingStoreRequest $request, ApprovalSetting $approval_setting)
    {
        $approval_setting->update($request->only([
            'from_amount',
            'to_amount',
        ]));

        $approval_setting->guarantors()->sync($request->users);

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('approval-settings.show', $approval_setting->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalSetting $approval_setting)
    {
        abort_if(Gate::denies('delete-approval-settings'), 401);

        $approval_setting->guarantors()->detach();
        $approval_setting->delete();

        request()->session()->flash('alert-success', 'Success deleted the data.');

        return back();
    }
}
