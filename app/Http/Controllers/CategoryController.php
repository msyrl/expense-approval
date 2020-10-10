<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('access-categories'), 401);

        $collection = Category::query();

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

        return view('categories.index', [
            'collection' => $collection,
            'sortables' => (new Category)->getSortables(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('create-categories'), 401);

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        $request->session()->flash('alert-success', 'Success created new data. <a href="' . route('categories.show', $category->id) . '">See details.</a>');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        abort_if(Gate::denies('access-categories'), 401);

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        abort_if(Gate::denies('edit-categories'), 401);

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryStoreRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        $category->update($request->validated());

        $request->session()->flash('alert-success', 'Success updated the data. <a href="' . route('categories.show', $category->id) . '">See details.</a>');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(Gate::denies('delete-categories'), 401);

        $category->delete();

        request()->session()->flash('alert-success', 'Success deleted the data.');

        return back();
    }
}
