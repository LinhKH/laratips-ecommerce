<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FlashDeal extends Model
{  
    use HasSlug;
    use HasFactory;

    protected $table = 'flash_deals';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('flash_title')
            ->saveSlugsTo('flash_slug');
    }
}
