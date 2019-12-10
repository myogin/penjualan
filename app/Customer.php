<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

    public function penjualans(){
        return $this->hasMany('App\Penjualan');
    }
}
