<?php
namespace Abd\Category\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function getParentAttribute()
    {
        return (is_null($this->parent_id)) ? 'ندارد' : $this->parentCategory->title;
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function subCategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
