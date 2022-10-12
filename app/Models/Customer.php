<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = "customer_id";
    
    protected $fillable = [
        'customer_name',
        'email',
        'tel_num',
        'address',
        'is_active'
    ];
    

    const ACTIVE = 1;
    const DEACTIVE = 0;

    public function scopeSimple($query)
    {
        return $query->select('customer_id','customer_name','email','tel_num','address');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', self::ACTIVE);
    }
    
    public function scopeDefaultSort($query){
        return $query->orderBy('customer_id', 'desc');
    }

    public function scopeUpdateCustomer($query,$data){
        return $query->update([
            'customer_name' => $data["name"],
            'email' => $data["email"],
            'tel_num' => $data["phone"],
            'address' => $data["address"]
        ]);
    }
    
    public function scopeParams($query,$searchData)
    {
        if(isset($searchData['nameSearch'])){
            $query->name($searchData['nameSearch']);
        }

        if(isset($searchData['emailSearch'])){
            $query->email($searchData['emailSearch']);
        }
        
        if(isset($searchData['phoneSearch'])){
            $query->phone($searchData['phoneSearch']);
        }

        if(isset($searchData['addressSearch'])){
            $query->address($searchData['addressSearch']);
        }

        return $query;
    }

    public function scopeId($query,$id)
    {
        return $query->where('customer_id', $id);
    }
    
    public function scopeName($query,$name)
    {
        return $query->where('customer_name', 'like','%'.$name.'%');
    }

    public function scopeEmail($query,$email)
    {
        return $query->where('email', 'like','%'.$email.'%');
    }

    public function scopePhone($query,$phone)
    {
        return $query->where('tel_num', 'like','%'.$phone.'%');
    }

    public function scopeAddress($query,$address)
    {
        return $query->where('address','like','%'.$address.'%');
    }

}
