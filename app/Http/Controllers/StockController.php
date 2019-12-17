<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Datatables;

class StockController extends Controller
{
    public function __construct()
    {
        // OTORISASI GATE
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-stock')) return $next($request);
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
        $stocks = \App\Stock::rightjoin('products', 'products.id', '=', 'stocks.product_id')->paginate(10);


        return view('stocks.index', ['stocks' => $stocks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('stocks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $name = $request->get('name');
        $new_Stock = new \App\Stock;
        $new_Stock->name = $name;
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('Stock_images', 'public');
            $new_Stock->image = $image_path;
        } else {
            $new_Stock->image = null;
        }

        $new_Stock->created_by = \Auth::user()->id;

        $new_Stock->slug = str_slug($name, '-');

        $new_Stock->save();

        return redirect()->route('stocks.index')->with('status', 'Stocksuccessfully created');
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
        $Stock = \App\Stock::findOrFail($id);
        return view('stocks.show', ['Stock' => $Stock]);
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
        $Stock_to_edit = \App\Stock::rightjoin('products', 'products.id', '=', 'stocks.product_id')->findOrFail($id);
        return $Stock_to_edit;
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
        $stok = $request->get('stock');

        $Stock = \App\Stock::findOrFail($id);

        $Stock->stok = $stok;
        $Stock->update();
        return response()->json([
            'success' => true,
            'message' => 'Category Created'
        ]);
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
        $Stock = \App\Stock::findOrFail($id);

        $Stock->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
    }
    public function StockSearch(Request $request)
    {
        $keyword = $request->get('q');
        $stocks = \App\Stock::where("name", "LIKE", "%$keyword%")->get();
        return $stocks;
    }
    public function apistock()
    {
        $stock = \App\Stock::rightjoin('products', 'products.id', '=', 'stocks.product_id')->get();
        return Datatables::of($stock)
            ->addColumn('action', function($stock){
                return '' .
                '<a onclick="editForm('. $stock->id .')" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
            })
            ->rawColumns(['action'])->make(true);
    }
}
