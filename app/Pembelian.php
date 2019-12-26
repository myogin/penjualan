<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('qty', 'harga_beli');;
    }

    public function details()
    {
        return $this->hasMany('App\PembelianProduct');
    }
}
