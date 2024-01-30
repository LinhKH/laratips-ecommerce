<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, HasSlug;
    use InteractsWithMedia;

    protected $casts = [
        'featured' => 'boolean',
        'show_on_slider' => 'boolean',
        'active' => 'boolean'
    ];

    protected $fillable = ['name'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeActive($builder)
    {
        return $builder->where('active', true);
    }

    public function scopeInActive($builder)
    {
        return $builder->where('active', false);
    }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
