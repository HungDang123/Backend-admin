<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::paginate(30);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $url = Storage::disk('public')->putFileAs('images', $file, $fileName);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $url,
        ]);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ProductResource(Product::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::find($id);

        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $url = Storage::disk('public')->putFileAs('images', $file, $fileName);

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $url,
        ]);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::find($id)->delete();
    }
}
