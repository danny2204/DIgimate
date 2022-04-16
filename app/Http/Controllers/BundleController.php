<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ProductTrait;
use App\Traits\BundleTrait;

class BundleController extends Controller
{
    use ProductTrait;
    use BundleTrait;

    public function calculateStock($quantity, $prodStock, $minStock) {
        if($quantity == 1) {
            if($prodStock < $minStock) return $prodStock;
            else return $prodStock;
        } else {
            $tempProdStock = $prodStock / $quantity;
            if($tempProdStock < $minStock) return $tempProdStock;
            else return $tempProdStock;
        }
    }

    public function addBundle(Request $request) {
        $validator = Validator::make($request->all(), [
            'SKU' => 'required',
            'products.*' => 'required',
            'quantities.*' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response('400 Bad Request', 400)->header('Content-Type', 'application/json');
        } else {
            $weight = 0;
            $price = 0;
            $minStock = 0;
            $products = [];

            foreach($request->products as $key => $product) {
                $prod = $this->getProduct($product);
                if($prod != null) {
                    $weight += $prod->weight;
                    $price += ($request->quantities[$key] * $prod->price);
                    $minStock = $this->calculateStock($request->quantities[$key], $prod->stock, $minStock);
                    array_push($products, $prod);
                } else {
                    return response('404 Product Not Found', 400)->header('Content-Type', 'application/json');
                }
            }

            $bundle = new Bundle;
            $bundle->SKU = $request->SKU;
            $bundle->weight = $weight;
            $bundle->bundling_price = $price;
            $bundle->bundling_stock = $minStock;
            $bundle->bundling_items = json_encode($products);
            $bundle->save();

            return response('200 New Bundle has been Added', 200)->header('Content-Type', 'application/json');
        }
    }

    public function getAllBundle() {
        $bundles = Bundle::paginate(2);
        if(sizeof($bundles) == 0) {
            return response("404 No Bundle Available", 400)->header('Content-Type', 'application/json');
        }
        foreach($bundles as $bundle) {
            $bundle->bundling_items = json_decode($bundle->bundling_items);
        }
        return response($bundles, 200)->header('Content-Type', 'application/json');
    }

    public function showBundle() {
        $bundle = $this->getBundle(request()->SKU)->first();
        if($bundle == null) {
            return response('404 Bundle Not Found', 404)->header('Content-Type', 'application/json');
        }
        $bundle->bundling_items = json_decode($bundle->bundling_items);
        return response($bundle, 200)->header('Content-Type', 'application/json');
    }

    public function deleteBundle() {
        if($this->getBundle(request()->SKU) == null) {
            return response('404 Bundle Not Found', 404)->header('Content-Type', 'application/json');
        } else {
            $bundle = $this->getBundle(request()->SKU);
            $bundle->delete();

            return response('200' . request()->SKU . ' has been deleted', 200)->header('Content-Type', 'application/json');
        }
    }

    public function updateBundle(Request $request) {
        if($this->getBundle(request()->SKU) == null) {
            return response('404 Bundle Not Found', 404)->header('Content-Type', 'application/json');
        } else {
            // return $this->getBundle(request()->SKU);
            $validator = Validator::make($request->all(), [
                'products.*' => 'required',
                'quantities.*' => 'required|integer'
            ]);
    
            if($validator->fails()) {
                return response('Bad Request', 400)->header('Content-Type', 'application/json');
            } else {
                
                $weight = 0;
                $price = 0;
                $minStock = 0;
                $products = [];

                foreach($request->products as $key => $product) {
                    $prod = $this->getProduct($product);
                    if($prod != null) {
                        $weight += $prod->weight;
                        $price += ($request->quantities[$key] * $prod->price);
                        $minStock = $this->calculateStock($request->quantities[$key], $prod->stock, $minStock);
                        array_push($products, $prod);
                    } else {
                        return response('404 Product Not Found', 400)->header('Content-Type', 'application/json');
                    }
                }
    
                $bundle = $this->getBundle(request()->SKU);
                $bundle->weight = $weight;
                $bundle->bundling_price = $price;
                $bundle->bundling_stock = $minStock;
                $bundle->bundling_items = json_encode($products);
                $bundle->save();
    
                return response($request->SKU.' updated', 200)->header('Content-Type', 'application/json');
            }
        }
    }

}
