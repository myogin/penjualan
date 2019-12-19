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
        if($request->get('year') != ''){
            $tahun_ini = $request->get('year');
        }else{
        $tahun_ini = Carbon::now()->format('Y');
    }
        $bulan_ini = Carbon::now()->format('m');

        // chart profit tahunan
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

        // chart barang laku bulanan
        $penjualan2 = DB::table('penjualans')
            ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
            ->join('products', 'products.id', '=', 'penjualan_product.product_id')
            ->select('products.nama_produk as name')
            ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', $tahun_ini )
            ->groupBy('products.nama_produk')
            ->orderBy('products.nama_produk', 'asc')->get();

        //query omset tahun ini
        $cari_omset = DB::table('penjualans')->selectRaw('sum(total_harga)as omset')
        ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
        ->first();
        $total_omset=$cari_omset->omset;

        //query mencari profit bulan ini
        $cari_profit = DB::table('penjualans')->selectRaw('sum(profit)as profit')
        ->whereYear('penjualans.tanggal_transaksi', $tahun_ini)
        ->first();
        $total_profit=$cari_profit->profit;

        //datatables
        if(request()->ajax())
     {
        if(!empty($request->from_date))
            {
                $penjualan = \App\Penjualan::with('customer')->with('products')
                ->whereBetween('tanggal_transaksi', array($request->from_date, $request->to_date))
                ->get();
                return Datatables::of($penjualan)
                    ->addColumn('show_photo', function ($penjualan) {
                        if ($penjualan->gambar == NULL) {
                            return 'No Image';
                        }
                        return '<img src="' . asset('storage/' . $penjualan->gambar) . '" width="120px" /><br>';
                    })
                    ->addColumn('action', function ($penjualan) {
                        return '' .
                        '<a  href="'.route('penjualans.edit', ['id' => $penjualan->id]).'" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> '.
                        '<a  href="'.route('invoiceTransaksi', ['id' => $penjualan->id]).'" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-print"></i> Invoice</a> ';
                    })
                    ->rawColumns(['show_photo', 'action'])
                    ->make(true);
            }else{
                $penjualan = \App\Penjualan::with('customer')->with('products')->get();
                return Datatables::of($penjualan)
                    ->addColumn('show_photo', function ($penjualan) {
                        if ($penjualan->gambar == NULL) {
                            return 'No Image';
                        }
                        return '<img src="' . asset('storage/' . $penjualan->gambar) . '" width="120px" /><br>';
                    })
                    ->addColumn('action', function ($penjualan) {
                        return '' .
                        '<a  href="'.route('penjualans.edit', ['id' => $penjualan->id]).'" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> '.
                        '<a  href="'.route('invoiceTransaksi', ['id' => $penjualan->id]).'" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-print"></i> Invoice</a> ';
                    })
                    ->rawColumns(['show_photo', 'action'])
                    ->make(true);
            }
        }

        $product_name =[];
        $bulan_a = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        $product_search = \App\Product::orderBy('nama_produk', 'asc')->get();

            foreach($product_search as $key2 =>$ps){


                $product_name[$key2]['name'] = $ps->nama_produk;

                foreach ($bulan_a as $key => $bulan) {
                        $penjualan3 = DB::table('penjualans')
                        ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
                        ->join('products', 'products.id', '=', 'penjualan_product.product_id')
                        ->select('products.nama_produk as name')
                        ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
                        ->where('products.nama_produk', $ps->nama_produk)
                        ->whereMonth('penjualans.tanggal_transaksi', $bulan )
                        ->groupBy('products.nama_produk')
                        ->get();

                        if(@$penjualan3[0]->y != null){
                            $product_name[$key2]['data'][$key] = $penjualan3[0]->y;
                        }else{
                            $product_name[$key2]['data'][$key]  = 0;
                        }
                    }
        }
        $terjual_qty = DB::table('penjualans')
                        ->join('penjualan_product', 'penjualans.id', '=', 'penjualan_product.penjualan_id')
                        ->selectRaw('cast(sum(penjualan_product.qty)as UNSIGNED) as y')
                        ->whereYear('penjualans.tanggal_transaksi',2019 )
                        ->get();
        $terjual_qty = $terjual_qty[0]->y;

        return view('laporans.index',['tahun_ini' => $tahun_ini,'bulan_ini' => $bulan_ini,
        'bulans' => $bulans, 'profit' => $profit,'penjualan2' => $penjualan2,
        'total_profit' =>$total_profit,
        'total_omset' =>$total_omset,
        'product_name' =>$product_name,
        'terjual' => $terjual_qty
        ]);
    }
}
