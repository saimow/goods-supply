<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function(){  

    Route::get('/products/data/{product}', [ProductController\Data::class, 'getProduct']);
    
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => 'admin',
    ], function(){

        Route::get('/products/data', [ProductController\Data::class, 'getData'])->name('products.data');

        Route::post('/products/store', [ProductController\Create::class, 'store'])->name('products.store');

        Route::put('/products/update/{product}', [ProductController\Update::class, 'update'])->name('products.update');

        Route::post('/products/media/upload', [ProductController\Media::class, 'upload'])->name('products.media.upload');
        Route::post('/products/media/add', [ProductController\Media::class, 'add'])->name('products.media.add');

        Route::post('/products/editor/upload', [ProductController\Editor::class, 'upload'])->name('products.editor.upload');

        Route::delete('/products/delete/{product}', [ProductController\Delete::class, 'destroy'])->name('products.destroy');
        
        Route::get('/products/get_slug', [ProductController\Create::class, 'getSlug'])->name('products.getSlug');

    });
});
