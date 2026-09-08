<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\categories as Category;
use Illuminate\Http\Request;

class productcontroller extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])->get();
        return view('products.index', compact('products'));
    }
    
    public function search(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category;

        $products = Product::with(['category', 'variants'])
            ->when($search, function ($query, $search) {
                $query->where('productName', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('categoryId', $categoryId);
            })
            ->get();

        $categories = Category::all();

        return view('product', compact('products', 'categories'));
    }
}