<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
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
        $Stock_to_edit = \App\Stock::findOrFail($id);
        return view('stocks.edit', ['Stock' => $Stock_to_edit]);
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
        $name = $request->get('name');
        $slug = $request->get('slug');

        $Stock = \App\Stock::findOrFail($id);

        $Stock->name = $name;
        $Stock->slug = $slug;

        if ($request->file('image')) {
            if ($Stock->image && file_exists(storage_path('app/public/' . $Stock->image))) {
                \Storage::delete('public/' . $Stock->name);
            }
            $new_image = $request->file('image')->store('Stock_images', 'public');
            $Stock->image = $new_image;
        }
        $Stock->updated_by = \Auth::user()->id;
        $Stock->slug = str_slug($name);
        $Stock->save();
        return redirect()->route('stocks.edit', ['id' => $id])->with('status', 'Stock succesfully update');
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
        return redirect()->route('stocks.index')->with('status', 'Stock successfully moved to trash');
    }
    public function StockSearch(Request $request)
    {
        $keyword = $request->get('q');
        $stocks = \App\Stock::where("name", "LIKE", "%$keyword%")->get();
        return $stocks;
    }
}
