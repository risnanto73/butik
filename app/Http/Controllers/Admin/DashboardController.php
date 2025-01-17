<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){

        $categoriesCount = Category::count();
        $productsCount = Product::count();

        return view('admin.dashboard', compact('categoriesCount', 'productsCount'));
    }
}
