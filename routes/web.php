<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::match(["GET", "POST"], "/register", function () {
    return redirect("/login");
})->name("register");

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/ajax/users/search', 'UserController@ajaxSearch')->name("usersSearch");
Route::resource("users", "UserController")->middleware('auth');
Route::get("/api/user", "UserController@apiuser")->name("api.user");


Route::get('/ajax/customers/search', 'CustomerController@customerSearch')->name("customerSearch");
Route::resource("customers", "CustomerController")->middleware('auth');
Route::get("/api/customer", "CustomerController@apicustomer")->name("api.customer");


Route::get('/ajax/suppliers/search', 'SupplierController@supplierSearch')->name("supplierSearch");
Route::resource("suppliers", "SupplierController")->middleware('auth');
Route::get("/api/supplier", "SupplierController@apisupplier")->name("api.supplier");

Route::get('/ajax/categories/search', 'CategoryController@categorySearch')->name("categorySearch");
Route::resource("categories", "CategoryController")->middleware('auth');
Route::get("/api/category", "CategoryController@apicategory")->name("api.category");

Route::get('/ajax/products/search', 'ProductController@productSearch')->name("productSearch");
Route::resource("products", "ProductController")->middleware('auth');
Route::get("/api/product", "ProductController@apiproduct")->name("api.product");

Route::resource("stocks", "StockController")->middleware('auth');
Route::resource("stockmaintains", "StockmaintainController")->middleware('auth');

Route::get("/api/stockM", "StockmaintainController@apistockM")->name("api.stockM");
Route::get("/api/stock", "StockController@apistock")->name("api.stock");

Route::resource("penjualans", "PenjualanController")->middleware('auth');
Route::get("/api/penjualan", "PenjualanController@apipenjualan")->name("api.penjualan");

Route::resource("pembelians", "PembelianController")->middleware('auth');
Route::get("/api/pembelian", "PembelianController@apipembelian")->name("api.pembelian");


Route::get("/api/tes", "HomeController@apites")->name("api.tes");

Route::get("penjualans/{id}/invoice","PenjualanController@invoice")->name("invoiceTransaksi")->middleware('auth');
Route::get("penjualans/{id}/invoice-print","PenjualanController@invoicePrint")->name("invoicePrint")->middleware('auth');

Route::get("pembelians/{id}/invoice","PembelianController@invoice")->name("invoiceTransaksi2")->middleware('auth');
Route::get("pembelians/{id}/invoice-print","PembelianController@invoicePrint")->name("invoicePrint2")->middleware('auth');

Route::get('laporan-penjualan', "LaporanController@index")->name("laporans.index")->middleware('auth');
Route::get('laporan-pembelian', "LaporanController@laporanBeli")->name("laporans2.index")->middleware('auth');
