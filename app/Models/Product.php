<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'price',
        'compare_at_price',
        'quantity',
        'sku',
        'barcode',
        'weight',
        'vendor',
        'has_variants',
        'visibility',
    ];

    protected $casts = [
        'visibility' => 'boolean',
        'has_variants' => 'boolean',
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function option_values(){
        return $this->hasManyThrough(OptionValue::class, Option::class);
    }

    public function variants(){
        return $this->hasMany(Variant::class);
    }

    public function variant_values(){
        return $this->hasManyThrough(VariantValue::class, Variant::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
