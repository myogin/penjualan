<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = \App\Product::paginate(10);
        return view('products.index', ['products' => $products]);
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
        $new_product = new \App\product;
        $new_product->kode_produk = $request->get('kode_produk');
        $new_product->nama_produk = $request->get('nama_produk');
        $new_product->category_id = $request->get('category_id');
        $new_product->keterangan = $request->get('keterangan');
        $new_product->satuan = $request->get('satuan');
        $new_product->harga_dasar = $request->get('harga_dasar');
        $new_product->harga_jual = $request->get('harga_jual');

        if ($request->file('produk')) {
            $file = $request->file('produk')->store('products', 'public');
            $new_product->gambar = $file;
        }

        $new_product->save();
        $product_id = $new_product->id;
        $new_Stock = new \App\Stock;
        $new_Stock->product_id = $product_id;
        $new_Stock->stok = 0;
        $new_Stock->save();
        return redirect()->route('products.index')->with('status', 'product successfully created.');
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
        $product = \App\Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
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
        $product = \App\Product::findOrFail($id);
        $product->kode_produk = $request->get('kode_produk');
        $product->nama_produk = $request->get('nama_produk');
        $product->category_id = $request->get('category_id');
        $product->keterangan = $request->get('keterangan');
        $product->satuan = $request->get('satuan');
        $product->harga_dasar = $request->get('harga_dasar');
        $product->harga_jual = $request->get('harga_jual');

        if ($request->file('produk')) {
            $file = $request->file('produk')->store('products', 'public');
            $product->gambar = $file;
        }

        $product->save();
        return redirect()->route('products.index')->with('status', 'product successfully created.');
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
        $product = \App\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Product successfully delete');
    }
    public function productSearch(Request $request)
    {
        $keyword = $request->get('q');
        $products = \App\Product::where("nama_produk", "LIKE", "%$keyword%")->get();
        return $products;
    }
}
