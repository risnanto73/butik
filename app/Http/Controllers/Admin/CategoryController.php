<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::select('id', 'name', 'slug','stock', 'description', 'image')->latest()->get();
        return view('admin.categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'nullable|numeric',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa string.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'description.string' => 'Deskripsi kategori harus berupa string.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'File yang diupload harus berformat jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran file yang diupload maksimal 2048 kilobytes.',
            'stock.string' => 'Stok kategori harus berupa angka.',
        ]);

        try {
            $slug = Str::slug($request->name) . '-' . time();


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('storage/categories'), $image_name);
                $data['image'] = $image_name;
            }

            $data['name'] = $request->name;
            $data['slug'] = $slug;
            $data['description'] = $request->description;
            $data['stock'] = $request->stock;

            Category::create($data);

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
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
        $data = Category::findOrFail($id);

        return view('admin.categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'nullable|numeric',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa string.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'description.string' => 'Deskripsi kategori harus berupa string.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'File yang diupload harus berformat jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran file yang diupload maksimal 2048 kilobytes.',
            'stock.string' => 'Stok kategori harus berupa angka.',
        ]);

        try {
            $data = Category::findOrFail($id);
            $slug = Str::slug($request->name) . '-' . time();

            $updateData = [
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'stock' => $request->stock,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('storage/categories'), $image_name);

                if ($data->image && file_exists(public_path('storage/categories/' . $data->image))) {
                    unlink(public_path('storage/categories/' . $data->image));
                }

                $updateData['image'] = $image_name;
            }

            $data->update($updateData);

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Category::findOrFail($id);
            $data->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
