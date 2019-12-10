<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }
}
