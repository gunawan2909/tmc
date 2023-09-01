<?php

namespace App\Http\Controllers;

use App\Events\CategoryDeleteEvent;
use Illuminate\Http\Request;
use App\Models\CategoryCommand;
use App\Events\CategoryStoreEvent;
use App\Events\CategoryUpdateEvent;
use App\Http\Resources\CategoryResource;
use App\Models\CategoryQuery;
use App\Models\ProductQuery;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category =  CategoryQuery::all();
        return  CategoryResource::collection($category);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $category = CategoryCommand::create($data);
        event(new CategoryStoreEvent($category));
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryQuery $category)
    {
        return new CategoryResource($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryCommand $category)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $category->update($data);
        event(new CategoryUpdateEvent($category));
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryCommand $category)
    {
        $category->delete();
        $response = [
            "Message" => "Category Telah di Hapus"
        ];
        event(new CategoryDeleteEvent($category));
        return response()->json($response);
    }
}
