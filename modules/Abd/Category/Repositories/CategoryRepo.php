<?php

namespace Abd\Category\Repositories;

use Abd\Category\Models\Category;

class CategoryRepo
{
    public function all()
    {
        return Category::all();
    }

    public function fidById($id)
    {
        return Category::findOrFail($id);
    }

    public function allExceptById($id)
    {
        return $this->all()->filter(function ($item) use($id){
            return $item->id != $id;
        });
    }

    public function store($values)
    {
        return Category::create([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function update($id, $values)
    {
        return Category::where('id',$id)->update([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function delete($id)
    {
        return Category::where('id', $id)->delete();
    }

    public function tree()
    {
        return Category::where('parent_id', null)->with('subCategories')->get();
    }
}
