<?php

namespace App\Models;

use App\Helpers\Money;
use App\Traits\Api\Cart\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductVariation extends Model
{
    use HasFactory, HasPrice;

    //accessors
    public function getFormattedPriceAttribute() {
        $value = $this->price ?? $this->product->price;
        $money =  new Money($value);
        return $money->formatted();
    }

    public function getPriceVariesAttribute() {
        // if it's null it falls back to parent product
        if(is_null($this->price)){
            return false;
        }
        return $this->price !== $this->product->price;
    }

     //relations
     public function type() {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function stocks() {
       return $this->hasMany(Stock::class);
    }

    public function stock() {
        return $this->hasOne(ProductVariationStockView::class);
    }


}
