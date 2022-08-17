<?php

namespace Abd\Category\Http\Controllers;

use Abd\Category\Repositories\CategoryRepo;
use Abd\Category\Responses\AjaxResponses;
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
        $categories = $this->repo->all();
        return view('Categories::index', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
        $this->repo->store($request);
        return back();
    }

    public function edit($categoryId)
    {
        $category = $this->repo->fidById($categoryId);
        $categories = $this->repo->allExceptById($categoryId);
        return view('Categories::edit', compact('category', 'categories'));
    }

    public function update($categoryId, CategoryRequest $request)
    {
        $this->repo->update($categoryId, $request);
        return back();
    }

    public function destroy($categoryId)
    {
        $this->repo->delete($categoryId);
        return AjaxResponses::SuccessResponse();
    }
}
