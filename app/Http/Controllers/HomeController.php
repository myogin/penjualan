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

        $data_penjualan=DB::select("SELECT products.nama_produk, CAST(SUM(penjualan_product.qty)as UNSIGNED) as qty, MONTH(penjualans.tanggal_transaksi) as month, sum(products.harga_jual*penjualan_product.qty) as omset
        from penjualans
        INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id
        INNER JOIN products ON products.id = penjualan_product.product_id

        where MONTH(penjualans.tanggal_transaksi) = MONTH(CURRENT_DATE()) AND YEAR(penjualans.tanggal_transaksi) = YEAR(CURRENT_DATE())
        GROUP BY products.nama_produk
        ");
        $omsets=DB::select("SELECT sum(products.harga_jual*penjualan_product.qty) as omset
        from penjualans
        INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id
        INNER JOIN products ON products.id = penjualan_product.product_id

        where MONTH(penjualans.tanggal_transaksi) = MONTH(CURRENT_DATE()) AND YEAR(penjualans.tanggal_transaksi) = YEAR(CURRENT_DATE())
        GROUP BY MONTH(penjualans.tanggal_transaksi)
        ");

        $penjualan_laba = DB::select("SELECT  MONTH(penjualans.tanggal_transaksi) as month , CAST(SUM((products.harga_jual-products.harga_dasar)*penjualan_product.qty)as UNSIGNED) as profit from penjualans INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id INNER JOIN products ON products.id = penjualan_product.product_id where YEAR(penjualans.tanggal_transaksi) = YEAR(CURRENT_DATE())  GROUP BY MONTH(penjualans.tanggal_transaksi)");

        $bulans = ["1","2","3","4","5","6","7","8","9","10","11","12"];
        $profit = [];
        foreach($bulans as $bulan){
            $penjualan_laba = DB::select("SELECT  MONTH(penjualans.tanggal_transaksi) as month , CAST(SUM((products.harga_jual-products.harga_dasar)*penjualan_product.qty)as UNSIGNED) as profit from penjualans INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id INNER JOIN products ON products.id = penjualan_product.product_id where YEAR(penjualans.tanggal_transaksi) = YEAR(CURRENT_DATE()) AND MONTH(penjualans.tanggal_transaksi) =  $bulan GROUP BY MONTH(penjualans.tanggal_transaksi)");
            $profit = $penjualan_laba;
        }
        // dd(json_encode($bulans));

        foreach ($penjualan_laba as $pl) {

            $profit[] = $pl->profit;
        }



        $categories = [];
        $data = [];
        $bulan = [];
        foreach ($data_penjualan as $dp) {
            $categories[] = $dp->nama_produk;
            $data[] = $dp->qty;
            $bulan[] = $dp->month;
        }


        return view('home', ['stok' => $stok,'penjualan_proses' => $penjualan_proses,'categories' => $categories,'data' => $data,'bulans' => $bulans,'profit' => $profit,'omsets' => $omsets]);
    }

    public function apites()
    {
        $penjualan = DB::select("SELECT  MONTH(penjualans.tanggal_transaksi) as month , CAST(SUM((products.harga_jual-products.harga_dasar)*penjualan_product.qty)as UNSIGNED) as profit from penjualans INNER JOIN penjualan_product ON penjualan_product.penjualan_id = penjualans.id INNER JOIN products ON products.id = penjualan_product.product_id where YEAR(penjualan_product.created_at) = YEAR(CURRENT_DATE()) GROUP BY MONTH(penjualans.tanggal_transaksi)");


        return $penjualan;
    }
}
