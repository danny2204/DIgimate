<?php

namespace App\Traits;

use App\Models\Bundle;

/**
 * 
 */
trait BundleTrait
{
    public function getBundle($SKU) {
        return Bundle::find($SKU);
    } 
}
