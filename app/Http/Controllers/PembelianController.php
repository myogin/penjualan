<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Carbon;

class PembelianController extends Controller
{
    public function __construct()
    {
        // OTORISASI GATE
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-pembelian')) return $next($request);
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
        return view('pembelians.index');
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
        $suppliers = \App\Supplier::All();
        return view('pembelians.create', ['products' => $products, 'suppliers' => $suppliers]);
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
            "supplier" => "required",
            "status" => "required",
            "product" => "required",
            "qty" => "required"
        ])->validate();

        $pembelian = new \App\Pembelian;
        $pembelian->created_by = \Auth::user()->id;
        $pembelian->supplier_id = $request->get('supplier');

        $pembelian->tanggal_transaksi =
            date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $mytime = Carbon::now();
        $invoice = \App\Pembelian::get('invoice_number')->last();
        if ($invoice === null) {
            $invoice_no = 3001;
        } else {
            $invoice_no = $invoice->invoice_number+1;
        }
        $pembelian->invoice_number = $invoice_no;
        $pembelian->status = $request->get('status');
        $pembelian->total_harga = 0;
        $pembelian->save();
        $pembelian_id = $pembelian->id;

        $total_harga = 0;

        foreach ($request->get('product') as $key => $brg) {
            $pembelian_product = new \App\PembelianProduct;
            $pembelian_product->pembelian_id = $pembelian_id;
            $pembelian_product->product_id = $brg;
            $pembelian_product->qty = $request->get('qty')[$key];


            $product = \App\Product::find($request->get('product')[$key]);
            $pembelian_product->harga_beli = $product->harga_dasar;
            $pembelian_product->save();

            $total_harga += $pembelian_product->harga_beli * $pembelian_product->qty;

            $new_Stock = \App\Stock::find($request->get('product')[$key]);
            $new_Stock->stok += $request->get('qty')[$key];
            $new_Stock->save();
        }

        $pembelian = \App\Pembelian::find($pembelian_id);
        $pembelian->total_harga = $total_harga;
        $pembelian->save();

        return redirect()->route('pembelians.create')->with('status', 'pembelian successfully created.');
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
        $pembelian = \App\Pembelian::findOrFail($id);
        $products = \App\Product::All();
        $suppliers = \App\Supplier::All();

        // $product = \App\Product::findOrFail($id);
        // $customer = \App\Customer::findOrFail($id);
        // , 'product' => $product, 'customer' => $customer
        return view('pembelians.edit', ['pembelian' => $pembelian, 'products' => $products, 'suppliers' => $suppliers]);
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
            "supplier" => "required",
            "status" => "required",
            "product" => "required",
            "qty" => "required"
        ])->validate();

        $pembelian = \App\Pembelian::findOrFail($id);
        $pembelian->supplier_id = $request->get('supplier');
        $pembelian->updated_by = \Auth::user()->id;
        $pembelian->tanggal_transaksi =
            date('Y-m-d', strtotime($request->get('tanggal_transaksi')));

        $pembelian->status = $request->get('status');
        $pembelian->total_harga = 0;
        $pembelian->save();
        $pembelian_id = $pembelian->id;

        $total_harga = 0;

        // kembalikan stok
        $detail_product = \App\PembelianProduct::where('pembelian_id', '=', $pembelian_id)->get();
        foreach($detail_product as $detail){
            $stock = \App\Stock::find($detail->product_id);
            $stock->stok -= $detail->qty;
            $stock->save();
        }

        // hapus product
        $detail_product = \App\PembelianProduct::where('pembelian_id', '=', $pembelian_id)->get();
        foreach($detail_product as $detail){
            $detail_product = \App\PembelianProduct::where('pembelian_id', '=', $detail->pembelian_id)
            ->where('product_id', '=', $detail->product_id)
            ->first();
            $detail_product->delete();
        }

        // update product
        foreach ($request->get('product') as $key => $brg) {
            $detail_product = \App\PembelianProduct::where('pembelian_id', '=', $pembelian_id)
            ->where('product_id', '=', $brg)
            ->first();

            if($detail_product != ''){
                $detail_product = \App\PembelianProduct::where('pembelian_id', '=', $pembelian_id)
                ->where('product_id', '=', $brg)
                ->first();
            }else{
                $detail_product = new \App\PembelianProduct;
            $detail_product->pembelian_id = $pembelian_id;
            $detail_product->product_id = $brg;
            }

            $detail_product->qty = $request->get('qty')[$key];


            $product = \App\Product::find($request->get('product')[$key]);
            $detail_product->harga_beli = $product->harga_dasar;
            $detail_product->save();

            $total_harga += $detail_product->harga_beli * $detail_product->qty;

            // update stock
            $new_Stock = \App\Stock::find($request->get('product')[$key]);
            $new_Stock->stok += $request->get('qty')[$key];
            $new_Stock->save();
        }

        $pembelian = \App\pembelian::find($pembelian_id);
        $pembelian->total_harga = $total_harga;
        $pembelian->save();



        return redirect()->route('pembelians.edit', ['id' => $id])->with('status', 'pembelian successfully updated');

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

    public function apipembelian()
    {
        $pembelian = \App\Pembelian::with('supplier')->with('products')->get();
        return Datatables::of($pembelian)
            ->addColumn('show_photo', function ($pembelian) {
                if ($pembelian->gambar == NULL) {
                    return 'No Image';
                }
                return '<img src="' . asset('storage/' . $pembelian->gambar) . '" width="120px" /><br>';
            })
            ->addColumn('action', function ($pembelian) {
                return '' .
                '<a  href="'.route('pembelians.edit', ['id' => $pembelian->id]).'" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
