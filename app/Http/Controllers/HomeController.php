<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stok = \App\Stock::where('stok','<=',10)->count();
        $penjualan_proses = \App\Penjualan::where('status','PROCESS')->count();

        $data_penjualan=DB::select("SELECT products.nama_produk, penjualan_product.qty, MONTH(penjualan_product.created_at) as month from penjualans
        INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id
        INNER JOIN products ON products.id = penjualan_product.product_id where MONTH(penjualan_product.created_at) = MONTH(CURRENT_DATE()) AND YEAR(penjualan_product.created_at) = YEAR(CURRENT_DATE()) GROUP BY products.nama_produk");


        $categories = [];
        $data = [];
        $bulan = [];
        foreach ($data_penjualan as $dp) {
            $categories[] = $dp->nama_produk;
            $data[] = $dp->qty;
            $bulan[] = $dp->month;
        }

        return view('home', ['stok' => $stok,'penjualan_proses' => $penjualan_proses,'categories' => $categories,'data' => $data,'bulan' => $bulan]);
    }
}
