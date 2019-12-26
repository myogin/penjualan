<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    public function __construct()
    {
        // OTORISASI GATE
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-penjualan')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
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

        foreach ($request->get('product') as $key => $brg) {
            $stock = \App\Stock::find($request->get('product')[$key]);
            $product = \App\Product::find($request->get('product')[$key]);
            if($request->get('qty')[$key] > $stock->stok ){
                return redirect()->route('penjualans.create')->with('message', 'Stok '. $product->nama_produk .' tidak mencukupi');
            }
        }


        $new_penjualan = new \App\Penjualan;
        $new_penjualan->created_by = \Auth::user()->id;
        $new_penjualan->customer_id = $request->get('customer');

        $new_penjualan->tanggal_transaksi =
            date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $mytime = Carbon::now();
        $invoice = \App\Penjualan::get('invoice_number')->last();
        if ($invoice === null) {
            $invoice_no = 7001;
        } else {
            $invoice_no = $invoice->invoice_number + 1;
        }
        $new_penjualan->invoice_number = $invoice_no;
        $new_penjualan->status = $request->get('status');
        $new_penjualan->total_harga = 0;
        $new_penjualan->profit = 0;
        $new_penjualan->shipping = $request->get('shipping');
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
    public function invoice($id)
    {
        //
        $penjualan = \App\Penjualan::findOrFail($id);
        $products = \App\Product::All();
        $customers = \App\Customer::All();

        // $product = \App\Product::findOrFail($id);
        // $customer = \App\Customer::findOrFail($id);
        // , 'product' => $product, 'customer' => $customer
        return view('penjualans.invoice', ['penjualan' => $penjualan, 'products' => $products, 'customers' => $customers]);
    }
    public function invoicePrint($id)
    {
        //
        $penjualan = \App\Penjualan::findOrFail($id);
        $products = \App\Product::All();
        $customers = \App\Customer::All();

        // $product = \App\Product::findOrFail($id);
        // $customer = \App\Customer::findOrFail($id);
        // , 'product' => $product, 'customer' => $customer
        return view('penjualans.invoice-print', ['penjualan' => $penjualan, 'products' => $products, 'customers' => $customers]);
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

        $validation = \Validator::make($request->all(),[
            "tanggal_transaksi" => "required",
            "customer" => "required",
            "status" => "required",
            "product" => "required",
            "qty" => "required"
        ])->validate();

        $penjualan = \App\Penjualan::findOrFail($id);
        $penjualan->customer_id = $request->get('customer');
        $penjualan->updated_by = \Auth::user()->id;
        $penjualan->tanggal_transaksi =
            date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $penjualan->status = $request->get('status');
        $penjualan->total_harga = 0;
        $penjualan->profit = 0;
        $penjualan->save();
        $penjualan_id = $penjualan->id;

        $total_harga = 0;
        $profit = 0;

        $penjualan->shipping = $request->get('shipping');
        // kembalikan stok
        $detail_product = \App\PenjualanProduct::where('penjualan_id', '=', $penjualan_id)->get();
        foreach($detail_product as $detail){
            $stock = \App\Stock::find($detail->product_id);
            $stock->stok += $detail->qty;
            $stock->save();
        }

        // hapus product
        $detail_product = \App\PenjualanProduct::where('penjualan_id', '=', $penjualan_id)->get();
        foreach($detail_product as $detail){
            $detail_product = \App\PenjualanProduct::where('penjualan_id', '=', $detail->penjualan_id)
            ->where('product_id', '=', $detail->product_id)
            ->first();
            $detail_product->delete();
        }

        // update product
        foreach ($request->get('product') as $key => $brg) {
            $detail_product = \App\PenjualanProduct::where('penjualan_id', '=', $penjualan_id)
            ->where('product_id', '=', $brg)
            ->first();

            if($detail_product != ''){
                $detail_product = \App\PenjualanProduct::where('penjualan_id', '=', $penjualan_id)
                ->where('product_id', '=', $brg)
                ->first();
            }else{
                $detail_product = new \App\PenjualanProduct;
            $detail_product->penjualan_id = $penjualan_id;
            $detail_product->product_id = $brg;
            }

            $detail_product->qty = $request->get('qty')[$key];


            $product = \App\Product::find($request->get('product')[$key]);
            $detail_product->harga_jual = $product->harga_jual;
            $detail_product->harga_beli = $product->harga_dasar;
            $detail_product->save();

            $total_harga += $detail_product->harga_jual * $detail_product->qty;
            $profit += ($detail_product->harga_jual - $detail_product->harga_beli) * $detail_product->qty;

            // update stock
            $new_Stock = \App\Stock::find($request->get('product')[$key]);
            $new_Stock->stok -= $request->get('qty')[$key];
            $new_Stock->save();
        }

        $penjualan = \App\Penjualan::find($penjualan_id);
        $penjualan->total_harga = $total_harga;
        $penjualan->profit = $profit;
        $penjualan->save();



        return redirect()->route('penjualans.edit', ['id' => $id])->with('status', 'Penjualan successfully updated');

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
                '<a  href="'.route('penjualans.edit', ['id' => $penjualan->id]).'" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> '.
                '<a  href="'.route('invoiceTransaksi', ['id' => $penjualan->id]).'" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-print"></i> Invoice</a> ';
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
