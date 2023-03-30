<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    
    }

    public function option_values(){
        return $this->hasMany(OptionValue::class);
    }

    public function variant_values(){
        return $this->hasMany(VariantValue::class);
    }
    
}
