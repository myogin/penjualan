<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    public function __construct()
    {
        // OTORISASI GATE
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-suppliers')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $supplier_email = $request->get('supplier_email');
        $suppliers = \App\supplier::where('email', 'LIKE', "%$supplier_email%")->paginate(10);

        return view('suppliers.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("suppliers.create");
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
        $new_supplier = new \App\supplier;
        $new_supplier->nama = $request->get('name');
        $new_supplier->email = $request->get('email');
        $new_supplier->perusahaan = $request->get('perusahaan');
        $new_supplier->phone = $request->get('phone');
        $new_supplier->address = $request->get('address');
        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $new_supplier->avatar = $file;
        }

        $new_supplier->save();

        return redirect()->route('suppliers.index')->with('status', 'supplier successfully created.');
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
        $supplier = \App\supplier::findOrFail($id);
        return view('suppliers.show', ['supplier' => $supplier]);
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
        $supplier = \App\supplier::findOrFail($id);
        return view('suppliers.edit', ['supplier' => $supplier]);
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
        $supplier = \App\supplier::findOrFail($id);
        $supplier->nama = $request->get('name');
        $supplier->email = $request->get('email');
        $supplier->perusahaan = $request->get('perusahaan');
        $supplier->phone = $request->get('phone');
        $supplier->address = $request->get('address');
        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $supplier->avatar = $file;
        }
        $supplier->save();
        return redirect()->route('suppliers.edit', ['id' => $id])->with('status', 'supplier succesfully updated');
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
        $supplier = \App\supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('status', 'supplier successfully delete');
    }
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $suppliers = \App\supplier::where("name", "LIKE", "%$keyword%")->get();
        return $suppliers;
    }
}
