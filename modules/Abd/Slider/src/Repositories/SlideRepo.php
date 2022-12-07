<?php

namespace Abd\Slider\Repositories;

use Abd\Category\Models\Category;
use Abd\Slider\Models\Slide;

class SlideRepo
{
    public function all()
    {
        return Slide::query()->orderBy('priority')->get();
    }

    public function fidById($id)
    {
        return Slide::findOrFail($id);
    }

    public function allExceptById($id)
    {
        return $this->all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });
    }

    public function store($values)
    {
        return Slide::create([
            'user_id' => auth()->id(),
            'media_id' => $values->media_id,
            'priority' => $values->priority,
            'link' => $values->link,
            'status' => $values->status,
        ]);
    }

    public function update($id, $values)
    {
        return Slide::where('id', $id)->update([
            'user_id' => auth()->id(),
            'media_id' => $values->media_id,
            'priority' => $values->priority,
            'link' => $values->link,
            'status' => $values->status,
        ]);
    }

    public function delete($id)
    {
        return Slide::where('id', $id)->delete();
    }
}
