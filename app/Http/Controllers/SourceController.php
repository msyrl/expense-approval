<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceStoreRequest;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SourceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-sources');

        $sources = Source::query();

        if (request()->filled('q')) {
            $q = request()->get('q');

            $sources = $sources->where('name', 'LIKE', "%{$q}%");
        }

        $sources = $sources->getPaginate();

        return view('sources.index', [
            'sources' => $sources,
            'sortables' => (new Source)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-sources');

        return view('sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SourceStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SourceStoreRequest $request)
    {
        $source = Source::create($request->validated());

        return redirect()
            ->route('sources.show', $source)
            ->with('success', 'Success created new data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        $this->authorize('access-sources');

        return view('sources.show', [
            'source' => $source,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        $this->authorize('edit-sources');

        return view('sources.edit', [
            'source' => $source
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SourceStoreRequest  $request
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(SourceStoreRequest $request, Source $source)
    {
        $source->update($request->validated());

        return redirect()
            ->route('sources.show', $source)
            ->with('success', 'Success updated the data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        $this->authorize('delete-sources');

        if ($source->expenses->count()) {
            return back()->with('error', 'Can\'t delete non-empty data.');
        }

        $source->delete();

        return redirect()
            ->route('sources.index', [
                'sort_by' => 'created_at|desc',
            ])
            ->with('success', 'Success deleted the data.');
    }
}
