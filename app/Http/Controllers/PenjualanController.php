<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('penjualans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = \App\Product::All();
        $customers = \App\Customer::All();
        return view('penjualans.create', ['products' => $products, 'customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $new_penjualan = new \App\Penjualan;
        $new_penjualan->customer_id = $request->get('customer');

        $new_penjualan->tanggal_transaksi =
        date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $mytime= Carbon::now();
        $invoice = \App\Penjualan::get('id')->last();
        if ($invoice === null) {
            $invoice_no = $mytime->format('Ymd') . "0001";
        } else {
            $invoice_no = $mytime->format('Ymd') . str_pad($invoice->id + 1, 4, '0', STR_PAD_LEFT);;
        }
        $new_penjualan->invoice_number = $invoice_no;
        $new_penjualan->status = $request->get('status');
        $new_penjualan->save();
        $penjualan_id = $new_penjualan->id;

        foreach ($request->get('product') as $key => $brg) {
            $new_penjualan_product = new \App\PenjualanProduct;
            $new_penjualan_product->penjualan_id = $penjualan_id;
            $new_penjualan_product->product_id = $brg;
            $new_penjualan_product->qty = $request->get('qty')[$key];
            $new_penjualan_product->save();

            $new_Stock = \App\Stock::find($request->get('product')[$key]);
            $new_Stock->stok -= $request->get('qty')[$key];
            $new_Stock->save();
        }


        return redirect()->route('penjualans.create')->with('status', 'penjualan successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $penjualan = \App\Penjualan::with('customer')->with('products')->findOrFail($id);
        return $penjualan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function apipenjualan()
    {
        $penjualan = \App\Penjualan::with('customer')->with('products')->get();
        return Datatables::of($penjualan)
            ->addColumn('show_photo', function($penjualan){
                if ($penjualan->gambar == NULL){
                    return 'No Image';
                }
                return '<img src="'.asset('storage/'.$penjualan->gambar).'" width="120px" /><br>';
            })
            ->addColumn('action', function($penjualan){
                return '' .
                    '<a onclick="editForm('. $penjualan->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> '
                    ;
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
