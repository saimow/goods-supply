<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Delete extends Controller
{
    public function destroy(Product $product){
        $product->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
