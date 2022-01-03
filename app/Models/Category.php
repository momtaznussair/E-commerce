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

class Category extends Model
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

    protected $fillable = [
        'active',
        'name',
        'slug'
    ];

    /**
     * returns filters that can be applied to this model by getAll() method in Repository
     * ckeck App\Repositories\SQL\Repository
     */
    public static  function filters() {
        return ['isActive', 'isTrashed', 'Search', 'parents'];
    }

     /**
     * The relations that should be soft deleted when this gets soft deleted.
     *
     * @var array
     */
    protected $softCascade = ['children'];

    //relations
    public function children() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    
    //scopes

    public function scopeParents($query) {
       return $query->whereNull('parent_id');
    }

}
