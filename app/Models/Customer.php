<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    const ACTIVE = 1;

    // public function listCustomer(){
    //     return DB::table('customers')->select('customer_id','customer_name','email','tel_num','address')->get();
    // }
    public function scopeSimple($query)
    {
        return $query->select('customer_id','customer_name','email','tel_num','address');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', self::ACTIVE);
    }
}
