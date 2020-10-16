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
        abort_if(Gate::denies('access-sources'), 401);

        $collection = Source::query();

        if (request()->filled('q')) {
            $q = request()->get('q');

            $collection = $collection->where('name', 'LIKE', "%{$q}%");
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

        return view('sources.index', [
            'collection' => $collection,
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
        abort_if(Gate::denies('create-sources'), 401);

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

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('sources.show', $source->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        abort_if(Gate::denies('access-sources'), 401);

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
        abort_if(Gate::denies('edit-sources'), 401);

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

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('sources.show', $source->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        abort_if(Gate::denies('delete-sources'), 401);

        $error = false;

        if (!$error) {
            $source->delete();
            request()->session()->flash('alert-success', 'Success deleted the data.');
        }

        return back();
    }
}
