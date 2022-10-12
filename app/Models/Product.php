<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const SALE = 1;

    const UNSALE = 0;


    public function scopeSimple($query){
        return $query->select('product_id','product_name','product_price','description','is_sales');
    }

    public function scopeDefaultSort($query){
        return $query->orderBy('product_id','desc');
    }
}
