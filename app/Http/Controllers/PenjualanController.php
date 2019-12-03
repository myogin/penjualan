<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $new_penjualan->invoice_number = $request->get('invoice');
        $new_penjualan->status = $request->get('status');
        $new_penjualan->save();
        $penjualan_id = $new_penjualan->id;

        foreach ($request->get('product') as $key => $brg) {
            $new_penjualan_product = new \App\PenjualanProduct;
            $new_penjualan_product->penjualan_id = $penjualan_id;
            $new_penjualan_product->product_id = $brg;
            $new_penjualan_product->qty = $request->get('qty')[$key];
            $new_penjualan_product->save();
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
}
