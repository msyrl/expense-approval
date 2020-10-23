<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalSettingStoreRequest;
use App\Models\ApprovalSetting;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-approval-settings');

        $approval_settings = ApprovalSetting::with(['guarantors']);

        if (request()->filled('q')) {
            $approval_settings = $approval_settings->where(function ($query) {
                $q = request()->get('q');

                return $query
                    ->where('from_amount', 'LIKE', "%{$q}%")
                    ->orWhere('to_amount', 'LIKE', "%{$q}%");
            });
        }

        $approval_settings = $approval_settings->getPaginate();

        return view('approval-settings.index', [
            'approval_settings' => $approval_settings,
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
        $this->authorize('create-approval-settings');

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

        return redirect()
            ->route('approval-settings.show', $approval_setting)
            ->with('success', 'Success created new data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalSetting $approval_setting)
    {
        $this->authorize('access-approval-settings');

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
        $this->authorize('edit-approval-settings');

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

        return redirect()
            ->route('approval-settings.show', $approval_setting)
            ->with('success', 'Success updated the data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalSetting  $approval_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalSetting $approval_setting)
    {
        $this->authorize('delete-approval-settings');

        $approval_setting->guarantors()->detach();
        $approval_setting->delete();

        return redirect()
            ->route('approval-settings.index')
            ->with('success', 'Success deleted the data.');
    }
}
