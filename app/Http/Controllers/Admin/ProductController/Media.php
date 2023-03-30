<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Media extends Controller
{
    public function upload(Request $request){
        $path = storage_path('app/public/tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('image');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return ['name'=>$name];
    }

    public function add(Request $request){
        $path = storage_path('app/public/products/media');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('image');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return ['name'=>$name];
    }
}
