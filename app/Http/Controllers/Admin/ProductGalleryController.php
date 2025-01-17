<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $items = $product->galleries()->get();

        return view('admin.products.gallery.index', compact(
            'items',
            'product'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin.products.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {

        try {
            $files = $request->file('files');

            foreach ($files as $file) {
                $file->storeAs('public/products/gallery', $file->hashName());
                $product->galleries()->create([
                    'image' => $file->hashName()
                ]);
            }

            return redirect()->route('admin.product.gallery.index', $product->id)->with('success', 'Gallery image has been uploaded');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.gallery.index', $product->id)->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ProductGallery $gallery)
    {
        $product = $gallery->product;
        $gallery = $product->galleries()->findOrFail($gallery->id);

        if ($gallery->image && file_exists(storage_path('app/public/products/gallery/' . $gallery->image))) {
            Storage::delete('public/products/gallery/' . $gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.product.gallery.index', $id)->with('success', 'Gallery image has been deleted');
    }
}
