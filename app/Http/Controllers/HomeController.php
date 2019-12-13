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


        $tahun_ini = Carbon::now()->format('Y');
        $bulan_ini = Carbon::now()->format('m');

        $bulans = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $profit = [];
        foreach ($bulans as $key => $bulan) {

            $penjualan_laba = \App\Penjualan::selectRaw('CAST(sum(profit) as UNSIGNED) as profit')
            ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
            ->whereMonth('tanggal_transaksi','=', $key+1 )
            ->groupby('year','month')
            ->first();
            if(!empty ( $penjualan_laba )){
                $profit[$key] = $penjualan_laba->profit;
            }else{
                $profit[$key] = 0;
            }
        }

        $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->select('products.nama_produk as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereMonth('penjualans.tanggal_transaksi', $bulan_ini )
            ->groupBy('products.nama_produk')
            ->get();

        $cari_profit = DB::table('penjualans')->selectRaw('sum(profit)as profit')
        ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
        ->first();
        $total_profit=$cari_profit->profit;
        return view('home',
        ['tahun_ini' => $tahun_ini,'bulan_ini' => $bulan_ini,
        'bulans' => $bulans, 'profit' => $profit,'penjualan2' => $penjualan2,
        'total_profit' =>$total_profit
        ]);
    }

    public function apites()
    {
        $month='12';
        $penjualan = \App\Penjualan::selectRaw('sum(profit) as profit')->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
            ->whereMonth('tanggal_transaksi', $month )
            ->groupby('year','month')
            ->first();

            $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->select('products.nama_produk as name')
            ->selectRaw('sum(penjualan_product.qty) as y')
            ->whereMonth('penjualans.tanggal_transaksi', 12 )
            ->groupBy('products.nama_produk')
            ->get();

            $total_profit = \App\Penjualan::selectRaw('sum(profit)as profit')
            ->whereYear('tanggal_transaksi', 2019)
            ->first();


        return $total_profit;
    }
}
