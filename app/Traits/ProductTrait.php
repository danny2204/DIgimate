<?php

namespace App\Traits;
use App\Models\Product;

/**
 * 
 */
trait ProductTrait
{
    public function getProduct($SKU) {
        return Product::find($SKU);
    } 
}
