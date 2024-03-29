<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function stock()
    {
        return $this->hasOne("App\Stock");
    }
    public function penjualans(){
        return $this->belongsToMany('App\Penjualan');
    }
}
