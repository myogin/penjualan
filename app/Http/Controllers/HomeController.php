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
        $bulan_ini_huruf = Carbon::now()->format('F');
        $bulans = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $profit = [];
        // total profit tahunan
        foreach ($bulans as $key => $bulan) {

            $penjualan_laba = \App\Penjualan::selectRaw('CAST(sum(total_harga) as UNSIGNED) as profit')
                ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
                ->whereMonth('tanggal_transaksi', '=', $key + 1)
                ->whereYear('tanggal_transaksi', $tahun_ini)
                ->groupby('year', 'month')
                ->first();
            if (!empty($penjualan_laba)) {
                $profit[$key] = $penjualan_laba->profit;
            } else {
                $profit[$key] = 0;
            }
        }
        $pengeluaran = [];
        // total pengeluaran tahunan
        foreach ($bulans as $key => $bulan) {

            $pembelian_pengeluaran = \App\Pembelian::selectRaw('CAST(sum(total_harga) as UNSIGNED) as pengeluaran')
                ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
                ->whereMonth('tanggal_transaksi', '=', $key + 1)
                ->whereYear('tanggal_transaksi', $tahun_ini)
                ->groupby('year', 'month')
                ->first();
            if (!empty($pembelian_pengeluaran)) {
                $pengeluaran[$key] = $pembelian_pengeluaran->pengeluaran;
            } else {
                $pengeluaran[$key] = 0;
            }
        }

        // chart bulat product terjual bulan ini
        $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->select('products.nama_produk as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereMonth('penjualans.tanggal_transaksi', $bulan_ini)
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->groupBy('products.nama_produk')
            ->get();

        $product_name = [];
        $bulan_a = [$bulan_ini];
        $product_search = \App\Product::orderBy('nama_produk', 'asc')->get();

        foreach ($product_search as $key2 => $ps) {


            $product_name[$key2]['name'] = $ps->nama_produk;

            foreach ($bulan_a as $key => $bulan) {
                $penjualan3 = DB::table('penjualans')
                    ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
                    ->join('products', 'products.id', '=', 'penjualan_product.product_id')
                    ->select('products.nama_produk as name')
                    ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
                    ->where('products.nama_produk', $ps->nama_produk)
                    ->whereMonth('penjualans.tanggal_transaksi', $bulan)
                    ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
                    ->groupBy('products.nama_produk')
                    ->get();

                if (@$penjualan3[0]->y != null) {
                    $product_name[$key2]['data'][$key] = $penjualan3[0]->y;
                } else {
                    $product_name[$key2]['data'][$key]  = 0;
                }
            }
        }

        //query mencari profit bulan ini
        $cari_profit = DB::table('penjualans')->selectRaw('sum(profit)as profit')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->first();
        $total_profit = $cari_profit->profit;

        //query pengeluaran tahun ini
        $cari_pengeluaran = DB::table('pembelians')->selectRaw('sum(total_harga)as total_harga')
            ->whereYear('tanggal_transaksi', $tahun_ini)
            ->first();
        $total_pengeluaran = $cari_pengeluaran->total_harga;

        //query pemasukan tahun ini
        $cari_pemasukan = DB::table('penjualans')->selectRaw('sum(total_harga)as total_harga')
            ->whereYear('tanggal_transaksi', $tahun_ini)
            ->first();
        $total_pemasukan = $cari_pemasukan->total_harga;

        //query omset bulan ini
        $cari_omset = DB::table('penjualans')->selectRaw('sum(total_harga)as omset')
            ->whereMonth('penjualans.tanggal_transaksi', $bulan_ini)
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->first();
        $total_omset = $cari_omset->omset;

        //query transaksi berstatus PROCESS
        $cari_process = \App\Penjualan::where('status', 'PROCESS')->whereMonth('penjualans.tanggal_transaksi', $bulan_ini)->count();

        //query cari stok kurang dari 10
        $cari_stock = \App\Stock::where('stok', '<=', 10)->count();

        //query cari user yang daftar bulan ini
        $cari_customer = \App\Customer::whereMonth('created_at', $bulan_ini)->count();

        return view(
            'home',
            [
                'tahun_ini' => $tahun_ini, 'bulan_ini' => $bulan_ini, 'bulan_ini_huruf' => $bulan_ini_huruf,
                'bulans' => $bulans,
                'profit' => $profit, 'pengeluaran' => $pengeluaran,
                'penjualan2' => $penjualan2,
                'chart_product' => $product_name,
                'total_profit' => $total_profit,
                'total_omset' => $total_omset,
                'total_pengeluaran' => $total_pengeluaran, 'total_pemasukan' => $total_pemasukan,
                'transaksi_proses' => $cari_process,
                'stock' => $cari_stock,
                'customer' => $cari_customer
            ]
        );
    }

    public function apites()
    {
        // chart bulat barang laku bulanan
        $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', 2019)
            ->groupBy('categories.name')
            ->orderBy('products.nama_produk', 'asc')->get();


            $customers = \App\Product::with('stock')->get();


            return $customers;

    }
}
