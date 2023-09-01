<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\ProductQuery;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $product = ProductQuery::filter(request(['sku', 'name', 'price_start', 'price_end', 'stock_start', 'stock_end', 'category_id', 'category_name']))->get();
        return ProductResource::collection($product);
    }
}
