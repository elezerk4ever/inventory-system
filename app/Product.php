<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    //helper functions 
    public function actQty(){ #actual qty
        if($this->carts->count()){
            $temp = 0;
            foreach($this->carts as $cart){
                $temp += $cart->qty;
            }
            return $this->qty - $temp;
        }
        return $this->qty;
    }
    public function sellPrice(){
        return $this->orig_price + $this->profit;
    }
    //relatioships 
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function carts(){
        return $this->hasMany(Cart::class);
    }
    public function incomes(){
        return $this->hasMany(Income::class);
    }
}
