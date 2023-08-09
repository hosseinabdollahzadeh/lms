<?php

namespace Abd\Category\Http\Controllers;

use Abd\Category\Models\Category;
use Abd\Category\Repositories\CategoryRepo;
use Abd\Common\Responses\AjaxResponses;
use App\Http\Controllers\Controller;
use Abd\Category\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public $repo;
    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->repo = $categoryRepo;
    }
    public function index()
    {
        $this->authorize('manage', Category::class);
        $categories = $this->repo->paginate();
        return view('Categories::index', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
        $this->repo->store($request);
        return back();
    }

    public function edit($categoryId)
    {
        $this->authorize('manage', Category::class);
        $category = $this->repo->findById($categoryId);
        $categories = $this->repo->allExceptById($categoryId);
        return view('Categories::edit', compact('category', 'categories'));
    }

    public function update($categoryId, CategoryRequest $request)
    {
        $this->authorize('manage', Category::class);
        $this->repo->update($categoryId, $request);
        $categories = $this->repo->all();
        return view('Categories::index', compact('categories'));
    }

    public function destroy($categoryId)
    {
        $this->authorize('manage', Category::class);
        $this->repo->delete($categoryId);
        return AjaxResponses::SuccessResponse();
    }
}
