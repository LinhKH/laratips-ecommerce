<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;
    use HasFactory;

    protected $table = 'categories';
    protected  $primaryKey = 'id';

    protected $fillable = [
        'category_name',
        'category_icon',
        'parent_category',
        'meta_title',
        'meta_desc',
        'category_slug',
        'status'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_category')->with('categories');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('category_name')
            ->saveSlugsTo('category_slug');
    }
}
