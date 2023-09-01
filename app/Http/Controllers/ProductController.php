<?php

namespace App\Http\Controllers;

use App\Events\ProductDeleteEvent;
use Illuminate\Http\Request;
use App\Models\ProductCommand;
use App\Events\ProductStoreEvent;
use App\Events\ProductUpdateEvent;
use App\Http\Resources\ProductResource;
use App\Models\ProductQuery;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = ProductQuery::all();
        return ProductResource::collection($product);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:product_queries,sku',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:category_queries,id'
        ]);
        $product = ProductCommand::create($data);
        event(new ProductStoreEvent($product));
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductQuery $product)
    {
        return new ProductResource($product);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCommand $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required',
        ]);
        $product->update($data);
        event(new ProductUpdateEvent($product));
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCommand $product)
    {
        $product->delete();
        $response = [
            "Message" => "Product Telah di Hapus"
        ];
        event(new ProductDeleteEvent($product));
        return response()->json($response);
    }
}
