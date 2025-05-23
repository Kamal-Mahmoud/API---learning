<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //$products = Product::with('category')->get();
        $products = Product::with('category')->paginate(9);
        // return $products;
        return ProductResource::collection($products);
    }
}
