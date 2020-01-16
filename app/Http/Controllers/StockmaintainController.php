<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Datatables;

class StockmaintainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = \App\Product::with('stock')->get();
        return view('stocks.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $id_product = $request->get('product');
        $stock = $request->get('stock');
        $ket = $request->get('keterangan');

        $new_maintain = new \App\Stockmaintain;
        $new_maintain->product_id = $id_product;
        $new_maintain->qty = $stock;
        $new_maintain->keterangan = $ket;
        $new_maintain->created_by = \Auth::user()->id;
        $new_maintain->statusM = $request->get('optionsRadios');
        $new_maintain->save();


        $new_Stock = \App\Stock::find($request->get('product'));

        if($request->get('optionsRadios')=="tambah"){
            $new_Stock->stok += $stock;
        }elseif($request->get('optionsRadios')=="kurang"){
            $new_Stock->stok -= $stock;
        }
        $new_Stock->save();

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
    public function apistockM()
    {
        $stock = DB::table('stockmaintains')

        ->join('products', 'products.id', '=', 'stockmaintains.product_id')
        ->join('stocks', 'stocks.id', '=', 'stockmaintains.product_id')
        ->join('users', 'users.id', '=', 'stockmaintains.created_by')
        ->get();
        return Datatables::of($stock)
            ->addColumn('action', function($stock){
                return '' .
                '<a onclick="editForm('. $stock->id .')" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
            })
            ->rawColumns(['action'])->make(true);
    }
}
