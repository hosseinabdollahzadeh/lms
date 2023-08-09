<?php
namespace Abd\Category\Models;

use Abd\Course\Models\Course;
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
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function path()
    {
        return route('categories.show', $this->id);
    }
}
