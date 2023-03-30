<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Data extends Controller
{
    public function getProduct(Product $product){
        $details = $product->toArray();
        $media = $product->images()->get()->toArray();

        $options = $product->options()->get();
        foreach($options as $key => $option){
            $option_values = $option->option_values()->get();
            $option['values'] = $option_values;
        }

        $option_values = $product->option_values()->get()->toArray();
        $variants = $product->variants()->get()->toArray();
        $variant_values = $product->variant_values()->get()->toArray();

        foreach($variants as $key => $variant){
            $variant['options'] = [];
            
            foreach($variant_values as $variant_value){
                if($variant_value['variant_id'] == $variant['id']){
                    $option_name = '';
                    $option_value_name = '';
                    foreach($options as $option){
                        if($option['id'] == $variant_value['option_id']){
                            $option_name = $option['name'];
                            break;
                        }
                    }
                    foreach($option_values as $option_value){
                        if($option_value['id'] == $variant_value['option_value_id']){
                            $option_value_name = $option_value['name'];
                            $variants[$key]['options'][] = ['name' => $option_name, 'value' => $option_value_name];
                            break;
                        }
                    }
                }
            }
        }

        return ['details'=>$details, 'media'=>$media, 'options'=>$options, 'variants'=>$variants];
    }
}
