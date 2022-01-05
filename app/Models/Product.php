<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Traits\Scopes\IsTrashed;
use App\Traits\Scopes\Searchable;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Searchable, SoftDeletes, IsTrashed, ActiveScope, SoftCascadeTrait;

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

    //relations

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }


    /**
     * returns filters that can be applied to this model by getAll() method in Repository
     * ckeck App\Repositories\SQL\Repository
     */
    public static  function filters() {
        return ['isActive', 'isTrashed', 'Search', 'category'];
    }

     /**
     * The relations that should be soft deleted when this gets soft deleted.
     *
     * @var array
     */
    protected $softCascade = ['variations'];

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

    //scopes

    public function scopeCategory($query, $category){
        return $query->whereHas('categories', function ($query) use ($category) {
            return $query->where('slug', $category);
        });
    }
}
