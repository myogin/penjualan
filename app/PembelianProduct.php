<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CompositeKey;

class PembelianProduct extends Model
{
    //
    use CompositeKey;
    public $table = "pembelian_product";

    protected $primaryKey = ['pembelian_id', 'product_id'];
}
