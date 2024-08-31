<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'products';

    // protected $casts = [
    //     'featured' => 'boolean',
    //     'show_on_slider' => 'boolean',
    //     'active' => 'boolean'
    // ];

    // protected $guarded  = [];

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class)->withTimestamps();
    // }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'creator_id');
    // }

    // public function scopeActive($builder)
    // {
    //     return $builder->where('active', true);
    // }

    // public function scopeInActive($builder)
    // {
    //     return $builder->where('active', false);
    // }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('product_name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category','id');
    }
}
