<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Providers\AppServiceProvider;
use App\Traits\ProductTrait;

class ProductController extends Controller
{
    use ProductTrait;

    public function showProduct() {
        return response($this->getProduct(request()->SKU), 200)->header('Content-Type', 'application/json');
    }

    public function showAllProduct() {
        return response(Product::paginate(2), 200)->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addNewProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'SKU' => 'required',
            'stock' => 'required|integer',
            'weight' => 'required',
            'price' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response('Bad Request', 400)->header('Content-Type', 'application/json');
        } else {
            $product = new Product;
            $product->SKU = $request->SKU;
            $product->stock = $request->stock;
            $product->weight = $request->weight;
            $product->price = $request->price;
            $product->save();

            return response('New Product Inserted', 200)->header('Content-Type', 'application/json');
        }
    }

    public function updateProduct(Request $request) {
        if($this->getProduct(request()->SKU) == null) {
            return response('404 Product Not Found', 404)->header('Content-Type', 'application/json');
        } else {
            // return $this->getProduct(request()->SKU);
            $validator = Validator::make($request->all(), [
                'stock' => 'required|integer',
                'weight' => 'required',
                'price' => 'required|integer'
            ]);
    
            if($validator->fails()) {
                return response('Bad Request', 400)->header('Content-Type', 'application/json');
            } else {
                $product = $this->getProduct(request()->SKU);
                $product->SKU = request()->SKU;
                $product->stock = $request->stock;
                $product->weight = $request->weight;
                $product->price = $request->price;
                $product->save();
    
                return response($request->SKU.' updated', 200)->header('Content-Type', 'application/json');
            }
        }
    }

    public function deleteProduct() {
        if($this->getProduct(request()->SKU) == null) {
            return response('404 Product Not Found', 404)->header('Content-Type', 'application/json');
        } else {
            $product = $this->getProduct(request()->SKU);
            $product->delete();

            return response(request()->SKU.' has been deleted', 200)->header('Content-Type', 'application/json');
        }
    }
}
