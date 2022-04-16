<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bundle;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bundle = new Bundle;
        $bundle->SKU = "BUNDLING Samsung S21 Pro and OPPO Reno5";
        $bundle->weight = 5;
        $bundle->bundling_items = json_encode(["Samsung S21 Pro Original", "Oppo Reno 5", "Case"]);
        $bundle->bundling_price = 15000000;
        $bundle->bundling_stock = 35;
        $bundle->save();
    }
}
