<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    public function type() {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }
}
