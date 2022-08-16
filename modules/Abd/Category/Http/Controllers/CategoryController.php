<?php

namespace Abd\Category\Http\Controllers;

use Abd\Category\Models\Category;
use App\Http\Controllers\Controller;
use Abd\Category\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        //todo CategoryRepo
        $categories = Category::all();
        return view('Categories::index', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
        //todo CategoryRepo
        Category::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
        ]);
        return back();
    }

    public function edit(Category $category)
    {
        //todo CategoryRepo
        $categories = Category::where('id' , '!=', $category->id)->get();
        return view('Categories::edit', compact('category', 'categories'));
    }

    public function update(Category $category, CategoryRequest $request)
    {
        //todo CategoryRepo
        $category->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
        ]);
        return back();
    }
}
