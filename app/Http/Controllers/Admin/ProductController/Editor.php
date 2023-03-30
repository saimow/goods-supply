<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Editor extends Controller
{
    public function upload(Request $request){
        
        $path = 'storage/products/description-media';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        $location = url('storage/products/description-media/'.$name);

        return response()->json([
            'location' => $location
        ]);
    }
}
