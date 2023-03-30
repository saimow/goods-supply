<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Create extends Controller
{
    public function index(){
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request){
        $details = $request->details;
        $options = $request->options;
        $variants = $request->variants;
        $media = $request->media;

        $product = Product::create($request->validated('details'));
        
        if($media){
            foreach($request->media as $image){
            
                $from = storage_path('app/public/tmp/uploads/'.$image['name']);
                $to = storage_path('app/public/products/media/'.$image['name']);
                
                File::move($from, $to);
                $product->images()->create([
                    'name' => $image['name'],
                    'size' => $image['size'],
                    'type' => $image['type'],
                ]);
            }
        }

        if($options){
            foreach ($options as $item) {
                if($item['name']){
                    $option = $product->options()->create([
                        'name' => $item['name']
                    ]);
        
                    foreach($item['values'] as $value){
                        $option->option_values()->create([
                            'name' => $value['name']
                        ]);
                    }
                }
            }
        }

        if($variants){
            $product_options = $product->options()->get();
            $product_option_values = $product->option_values()->get();
            foreach($variants as $variant){
                $product_variant = $product->variants()->create([
                    'is_default' => $variant['is_default'],
                    'image' => $variant['image'],
                    'price' => $variant['price'],
                    'compare_at_price' => $variant['compare_at_price'],
                    'quantity' => $variant['quantity'],
                    'sku' => $variant['sku'],
                    'barcode' => $variant['barcode'],
                    'weight' => $variant['weight'],
                ]);
    
                $option_id = null;
                $option_value_id = null;
                foreach($variant['options'] as $item){
                    foreach($product_options as $option){
                        if($option->name == $item['name']){
                            $option_id = $option->id;
                            break;
                        }
                    }
                    foreach($product_option_values as $value){
                        if($value->name == $item['value']){
                            $option_value_id = $value->id;
                            break;
                        }
                    }
                    $product_variant->variant_values()->create([
                        'option_id' => $option_id,
                        'option_value_id' => $option_value_id,
                    ]);
                }
            }
        }

        return response()->json(['success' => true], 200);
    }

    public function getSlug(Request $request){
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);

        return ['slug'=>$slug];
    }
}
