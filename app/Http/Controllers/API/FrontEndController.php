<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;

class FrontEndController extends Controller
{
    public function category(Request $request)
    {
        try {
            // Ambil parameter filter dari request
            $query = Category::query();

            // Filter berdasarkan nama (opsional)
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Sorting berdasarkan kolom tertentu (opsional)
            $sortBy = $request->get('sort_by', 'created_at'); // Default sorting by `created_at`
            $sortDirection = $request->get('sort_direction', 'asc'); // Default `asc`

            if (in_array($sortDirection, ['asc', 'desc'])) {
                $query->orderBy($sortBy, $sortDirection);
            }

            // Limit jumlah data (opsional)
            $limit = $request->get('limit', 10); // Default limit 10
            $categories = $query->paginate($limit);

            return ResponseFormatter::success($categories, 'Data kategori berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data kategori gagal diambil: ' . $e->getMessage(), 500);
        }
    }

    public function categoryDetail($slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                return ResponseFormatter::success($category, 'Data kategori berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data kategori tidak ditemukan', 404);
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data kategori gagal diambil: ' . $e->getMessage(), 500);
        }
    }

    public function product(Request $request)
    {
        try {
            // Ambil parameter filter dari request
            $query = Product::with('category'); // Eager load relasi category
    
            // Filter berdasarkan nama (opsional)
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
    
            // Sorting berdasarkan kolom tertentu (opsional)
            $sortBy = $request->get('sort_by', 'created_at'); // Default sorting by `created_at`
            $sortDirection = $request->get('sort_direction', 'asc'); // Default `asc`
    
            if (in_array($sortDirection, ['asc', 'desc'])) {
                $query->orderBy($sortBy, $sortDirection);
            }
    
            // Limit jumlah data (opsional)
            $limit = $request->get('limit', 10); // Default limit 10
            $products = $query->paginate($limit);
    
            return ResponseFormatter::success($products, 'Data produk berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data produk gagal diambil: ' . $e->getMessage(), 500);
        }
    }
    

    public function productDetail($slug)
    {
        try {
            $product = Product::with('galleries')->where('slug', $slug)->first();

            if ($product) {
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ditemukan', 404);
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data produk gagal diambil: ' . $e->getMessage(), 500);
        }
    }

    public function productGallery(Request $request, $id)
    {
        try {
            $product = Product::with('galleries')->find($id);

            if ($product) {
                return ResponseFormatter::success($product, 'Data galeri produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data galeri produk tidak ditemukan', 404);
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data galeri produk gagal diambil: ' . $e->getMessage(), 500);
        }
    }

}
