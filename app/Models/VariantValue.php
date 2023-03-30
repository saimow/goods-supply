<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id',
        'option_value_id'
    ];

    public function variant(){
        return $this->belongsTo(Variant::class);
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }

    public function option_value(){
        return $this->belongsTo(OptionValue::class);
    }
}
