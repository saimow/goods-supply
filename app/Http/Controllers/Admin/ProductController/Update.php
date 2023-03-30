<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Option;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Update extends Controller
{
    public function index(Product $product){
        return view('admin.products.update', ['product'=>$product]);
    }

    public function update(Product $product, UpdateProductRequest $request){
        $details = $request->details;
        $options = $request->options;
        $variants = $request->variants;
        $media = $request->media;

        $product->update($request->validated('details'));

        if($media){
            if($media['added']){
                foreach($request->media['added'] as $image){
                    $product->images()->create([
                        'name' => $image['name'],
                        'size' => $image['size'],
                        'type' => $image['type'],
                    ]);
                }
            }
            if($media['removed']){
                foreach($request->media['removed'] as $image){
                    File::delete(storage_path('app/public/products/media/'.$image['name']));
                    $product->images()->where('name', $image['name'])->delete();
                }
            }
        }

        if(!isset($details['reset'])){
            if($options){
                foreach($options as $key => $option){
                    Option::where('id', $option['id'])->update([
                        'name' => $option['name']
                    ]);
                }
            }
    
            if($variants){
                foreach($variants as $key => $variant){
                    Variant::where('id', $variant['id'])->update($request->validated('variants.'.$key));
                }
            }
        }else{
            $product->options()->delete();
            $product->variants()->delete();
            
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
        }

        return response()->json(['success' => true], 200);
    }
}
