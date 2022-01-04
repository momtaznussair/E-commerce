<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Traits\Scopes\IsTrashed;
use App\Traits\Scopes\Searchable;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Searchable, SoftDeletes, IsTrashed, ActiveScope;

    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    /**
     * returns filters that can be applied to this model by getAll() method in Repository
     * ckeck App\Repositories\SQL\Repository
     */
    public static  function filters() {
        return ['isActive', 'isTrashed', 'Search'];
    }

    protected $fillable = [
        'name',
        'price',
        'slug',
        'description',
        'active'
    ];

    public function getRouteKeyName() {
        return 'slug';
    }
}
