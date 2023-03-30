<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Show extends Controller
{
    public function index($slug){
        $product = Product::where('slug', $slug)->first();
        
        return view('user.products.show',['id' => $product->id]);
    }
}
