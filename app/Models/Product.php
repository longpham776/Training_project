<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $primaryKey = "product_id";

    protected $fillable = [
        'product_id',
        'product_name',
        'product_image',
        'product_price',
        'is_sales',
        'description'
    ];

    const SALE = 1;

    const UNSALE = 0;


    public function scopeSimple($query){
        return $query->select('product_id','product_name','product_price','description','is_sales');
    }

    public function scopeDefaultSort($query){
        return $query->orderBy('created_at','desc');
    }

    public function scopeUpdateProduct($query,$data,$nameImage){
        if(!$nameImage){
            return $query->update([
                'product_name' => $data["name"],
                'product_price' => $data["price"],
                'description' => $data["description"],
                'is_sales' => $data["sale"]
            ]);
        }

        return $query->update([
            'product_name' => $data["name"],
            'product_image' => $nameImage,
            'product_price' => $data["price"],
            'description' => $data["desciption"],
            'is_sales' => $data["sale"]
        ]);
    }

    public function scopeParams($query,$searchData){

        if(isset($searchData['nameSearch'])){
            $query->name($searchData['nameSearch']);
        }

        if(isset($searchData['saleSearch'])){
            $query->sale($searchData['saleSearch']);
        }
        
        if(isset($searchData['priceFromSearch']) && isset($searchData['priceToSearch'])){
            if($searchData['priceToSearch'] < $searchData['priceFromSearch']){
                $query->price($searchData['priceToSearch'],$searchData['priceFromSearch']);
            }else{
                $query->price($searchData['priceFromSearch'],$searchData['priceToSearch']);
            }
        }

        return $query;
    }

    public function scopeId($query,$id){
        return $query->where('product_id',$id);
    }

    public function scopeName($query,$name){
        return $query->where('product_name','like','%'.$name.'%');
    }

    public function scopeSale($query,$sale){
        return $query->where('is_sales',$sale);
    }

    public function scopePrice($query,$priceFrom,$priceTo){
        return $query
        ->where('product_price','>=',$priceFrom)
        ->where('product_price','<=',$priceTo);
    }
}
