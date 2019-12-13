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

        $validation = \Validator::make($request->all(),[
            "tanggal_transaksi" => "required",
            "customer" => "required",
            "status" => "required",
            "product" => "required",
            "qty" => "required"
        ])->validate();


        $new_penjualan = new \App\Penjualan;
        $new_penjualan->user_id = \Auth::user()->id;
        $new_penjualan->customer_id = $request->get('customer');

        $new_penjualan->tanggal_transaksi =
            date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $mytime = Carbon::now();
        $invoice = \App\Penjualan::get('id')->last();
        if ($invoice === null) {
            $invoice_no = $mytime->format('Ymd') . "0001";
        } else {
            $invoice_no = $mytime->format('Ymd') . str_pad($invoice->id + 1, 4, '0', STR_PAD_LEFT);;
        }
        $new_penjualan->invoice_number = $invoice_no;
        $new_penjualan->status = $request->get('status');
        $new_penjualan->total_harga = 0;
        $new_penjualan->profit = 0;
        $new_penjualan->save();
        $penjualan_id = $new_penjualan->id;

        $total_harga = 0;
        $profit = 0;

        foreach ($request->get('product') as $key => $brg) {
            $new_penjualan_product = new \App\PenjualanProduct;
            $new_penjualan_product->penjualan_id = $penjualan_id;
            $new_penjualan_product->product_id = $brg;
            $new_penjualan_product->qty = $request->get('qty')[$key];


            $product = \App\Product::find($request->get('product')[$key]);
            $new_penjualan_product->harga_jual = $product->harga_jual;
            $new_penjualan_product->harga_beli = $product->harga_dasar;
            $new_penjualan_product->save();

            $total_harga += $new_penjualan_product->harga_jual * $new_penjualan_product->qty;
            $profit += ($new_penjualan_product->harga_jual - $new_penjualan_product->harga_beli) * $new_penjualan_product->qty;

            $new_Stock = \App\Stock::find($request->get('product')[$key]);
            $new_Stock->stok -= $request->get('qty')[$key];
            $new_Stock->save();
        }

        $new_penjualan = \App\Penjualan::find($penjualan_id);
        $new_penjualan->total_harga = $total_harga;
        $new_penjualan->profit = $profit;
        $new_penjualan->save();



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
        $penjualan = \App\Penjualan::findOrFail($id);
        $products = \App\Product::All();
        $customers = \App\Customer::All();

        // $product = \App\Product::findOrFail($id);
        // $customer = \App\Customer::findOrFail($id);
        // , 'product' => $product, 'customer' => $customer
        return view('penjualans.edit', ['penjualan' => $penjualan, 'products' => $products, 'customers' => $customers]);
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
            ->addColumn('show_photo', function ($penjualan) {
                if ($penjualan->gambar == NULL) {
                    return 'No Image';
                }
                return '<img src="' . asset('storage/' . $penjualan->gambar) . '" width="120px" /><br>';
            })
            ->addColumn('action', function ($penjualan) {
                return '' .
                '<a  href="'.route('penjualans.edit', ['id' => $penjualan->id]).'" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
