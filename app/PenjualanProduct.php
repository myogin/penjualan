<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompositeKey;

class PenjualanProduct extends Model
{
    //
    use CompositeKey;
    public $table = "penjualan_product";

    protected $primaryKey = ['penjualan_id', 'product_id'];
}
