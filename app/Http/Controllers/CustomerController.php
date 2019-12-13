<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Yajra\DataTables\Datatables;

class CustomerController extends Controller
{
    public function __construct()
    {
        // OTORISASI GATE
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-customers')) return $next($request);
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
        $customer_email = $request->get('customer_email');
        $customers = \App\customer::where('email', 'LIKE', "%$customer_email%")->paginate(10);

        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("customers.create");
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'perusahaan' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'avatar' => 'required'
        ])->validate();

        $new_customer = new \App\customer;
        $new_customer->nama = $request->get('name');
        $new_customer->email = $request->get('email');
        $new_customer->perusahaan = $request->get('perusahaan');
        $new_customer->phone = $request->get('phone');
        $new_customer->address = $request->get('address');
        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $new_customer->avatar = $file;
        }

        $new_customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Category Created'
        ]);
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
        $customer = \App\customer::findOrFail($id);
        return view('customers.show', ['customer' => $customer]);
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
        $customer = \App\customer::findOrFail($id);
        return $customer;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'perusahaan' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ])->validate();

        $customer = \App\customer::findOrFail($id);
        $customer->nama = $request->get('name');
        $customer->email = $request->get('email');
        $customer->perusahaan = $request->get('perusahaan');
        $customer->phone = $request->get('phone');
        $customer->address = $request->get('address');
        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $customer->avatar = $file;
        }
        $customer->update();
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
        $customer = \App\Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('status', 'customer successfully delete');
    }
    public function customerSearch(Request $request)
    {
        $keyword = $request->get('q');
        $customers = \App\Customer::where("nama", "LIKE", "%$keyword%")->get();
        return $customers;
    }
    public function apicustomer()
    {
        $customer = \App\Customer::all();
        return Datatables::of($customer)
            ->addColumn('show_photo', function($customer){
                if ($customer->avatar == NULL){
                    return 'No Image';
                }
                return '<img src="'.asset('storage/'.$customer->avatar).'" width="120px" /><br>';
            })
            ->addColumn('action', function($customer){
                return '' .
                '<a onclick="editForm('. $customer->id .')" class="btn btn-info btn-flat btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> '.
                '<a onclick="showForm('. $customer->id .')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-eye"></i> Show</a> '  ;

            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
