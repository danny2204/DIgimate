<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $product = new Product;
        $product->SKU = "Samsung S21 Pro Original";
        $product->stock = 52;
        $product->price = 10000000;
        $product->weight = 2;
        $product->save();

        $product2 = new Product;
        $product2->SKU = "Oppo Reno 5";
        $product2->stock = 50;
        $product2->price = 5000000;
        $product2->weight = 2;
        $product2->save();

        $product3 = new Product;
        $product3->SKU = "Case";
        $product3->stock = 70;
        $product3->price = 50000;
        $product3->weight = 1;
        $product3->save();

    }
}
