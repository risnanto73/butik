<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('category')->latest()->get();

        return view('admin.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ], [
            'category_id.required' => 'Katagori wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.numeric' => 'Jumlah harus berupa angka.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {

            $data = $request->all();
            $data['slug'] = Str::slug($request->name) . '-' . time();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                $image->storeAs('public/products', $imageName);
                $data['image'] = $imageName;
            }

            Product::create($data);

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        $data = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->get();

        return view('admin.products.edit', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ], [
            'category_id.required' => 'Katagori wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.numeric' => 'Jumlah harus berupa angka.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {

            $data = Product::findOrFail($id);
            $data->name = $request->name;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->price = $request->price;
            $data->quantity = $request->quantity;
            $data->slug = Str::slug($request->name) . '-' . time();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');

                if ($data->image) {
                    Storage::delete('public/products/' . $data->image);
                }

                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/products', $imageName);
                $data->image = $imageName;
            }

            $data->save();

            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Product::findOrFail($id);

            if ($data->image) {
                Storage::delete('public/products/' . $data->image);
            }

            $data->delete();

            return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
