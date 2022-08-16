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
}
