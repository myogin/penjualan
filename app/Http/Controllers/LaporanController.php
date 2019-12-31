<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->get('year') != '') {
            $tahun_ini = $request->get('year');
        } else {
            $tahun_ini = Carbon::now()->format('Y');
        }
        $bulan_ini = Carbon::now()->format('m');

        // chart pendapatan di tahun
        $bulans = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $profit = [];

        foreach ($bulans as $key => $bulan) {

            $penjualan_laba = \App\Penjualan::selectRaw('CAST(sum(profit) as UNSIGNED) as profit')
                ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
                ->whereMonth('tanggal_transaksi', '=', $key + 1)
                ->whereYear('tanggal_transaksi', '=', $tahun_ini)
                ->groupby('year', 'month')
                ->first();
            if (!empty($penjualan_laba)) {
                $profit[$key] = $penjualan_laba->profit;
            } else {
                $profit[$key] = 0;
            }
        }

        // chart bulat barang laku bulanan
        $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->groupBy('categories.name')
            ->orderBy('products.nama_produk', 'asc')->get();

        //query omset tahun ini
        $cari_omset = DB::table('penjualans')->selectRaw('sum(total_harga)as omset')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->first();
        $total_omset = $cari_omset->omset;

        //query mencari profit bulan ini
        $cari_profit = DB::table('penjualans')->selectRaw('sum(profit)as profit')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->first();
        $total_profit = $cari_profit->profit;

        //datatables
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $penjualan = \App\Penjualan::with('customer')->with('products')
                    ->whereBetween('tanggal_transaksi', array($request->from_date, $request->to_date))
                    ->get();
            } else {
                $penjualan = \App\Penjualan::with('customer')->with('products')->get();
            }
            return Datatables::of($penjualan)
                ->addColumn('show_photo', function ($penjualan) {
                    if ($penjualan->gambar == NULL) {
                        return 'No Image';
                    }
                    return '<img src="' . asset('storage/' . $penjualan->gambar) . '" width="120px" /><br>';
                })
                ->addColumn('action', function ($penjualan) {
                    return '' .
                        '<a  href="' . route('penjualans.edit', ['id' => $penjualan->id]) . '" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                        '<a  href="' . route('invoiceTransaksi', ['id' => $penjualan->id]) . '" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-print"></i> Invoice</a> ';
                })
                ->rawColumns(['show_photo', 'action'])
                ->make(true);
        }

        $product_name = [];
        $bulan_a = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
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
        $terjual_qty = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->get();
        $terjual_qty = $terjual_qty[0]->y;

        //cari customer paling banyak mesen
        $rank_customer = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('customers', 'customers.id', '=', 'penjualans.customer_id')
            ->select('customers.nama as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as jumlah')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->groupBy('customers.nama')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();

        //cari product paling laku
        $rank_product = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->select('products.nama_produk as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as jumlah')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
            ->groupBy('products.nama_produk')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();



        return view('laporans.index', [
            'tahun_ini' => $tahun_ini, 'bulan_ini' => $bulan_ini,
            'bulans' => $bulans, 'profit' => $profit, 'penjualan2' => $penjualan2,
            'total_profit' => $total_profit,
            'total_omset' => $total_omset,
            'product_name' => $product_name,
            'terjual' => $terjual_qty,
            'rank_customer' => $rank_customer,
            'rank_product' => $rank_product
        ]);
    }





    public function laporanBeli(Request $request)
    {

        //datatables

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $pembelian = \App\Pembelian::with('supplier')->with('products')
                    ->whereBetween('tanggal_transaksi', array($request->from_date, $request->to_date))
                    ->get();
            } else {
                $pembelian = \App\Pembelian::with('supplier')->with('products')->get();
            }

            return Datatables::of($pembelian)
                ->addColumn('action', function ($pembelian) {
                    return '' .
                        '<a  href="' . route('pembelians.edit', ['id' => $pembelian->id]) . '" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
                })
                ->rawColumns(['action'])->make(true);
        }

        if ($request->get('year') != '') {
            $tahun_ini = $request->get('year');
        } else {
            $tahun_ini = Carbon::now()->format('Y');
        }
        $bulan_ini = Carbon::now()->format('m');

        // chart pendapatan di tahun
        $bulans = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $pengeluaran = [];

        foreach ($bulans as $key => $bulan) {

            $pengeluaran_beli = \App\Pembelian::selectRaw('CAST(sum(total_harga) as UNSIGNED) as total_harga')
                ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
                ->whereMonth('tanggal_transaksi', '=', $key + 1)
                ->whereYear('tanggal_transaksi', '=', $tahun_ini)
                ->groupby('year', 'month')
                ->first();
            if (!empty($pengeluaran_beli)) {
                $pengeluaran[$key] = $pengeluaran_beli->total_harga;
            } else {
                $pengeluaran[$key] = 0;
            }
        }

        //query pengeluaran tahun ini
        $cari_pengeluaran = DB::table('pembelians')->selectRaw('sum(total_harga)as total_harga')
            ->whereYear('tanggal_transaksi', $tahun_ini)
            ->first();
        $total_pengeluaran = $cari_pengeluaran->total_harga;

        //cari supplier paling banyak mesen
        $rank_supplier = DB::table('pembelians')
            ->join('pembelian_product', 'pembelians.id', '=', 'pembelian_product.pembelian_id')
            ->join('suppliers', 'suppliers.id', '=', 'pembelians.supplier_id')
            ->select('suppliers.nama as name')
            ->selectRaw('cast(sum(pembelian_product.qty)as UNSIGNED) as jumlah')
            ->whereYear('pembelians.tanggal_transaksi', $tahun_ini)
            ->groupBy('suppliers.nama')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();

        return view(
            'laporans.index2',
            [
                'tahun_ini' => $tahun_ini, 'bulan_ini' => $bulan_ini,
                'bulans' => $bulans,
                'pengeluaran' => $pengeluaran,
                'total_pengeluaran' => $total_pengeluaran,
                'rank_supplier' => $rank_supplier
            ]
        );
    }
}
