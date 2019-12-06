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
Route::resource("users", "UserController");
Route::get("/api/user", "UserController@apiuser")->name("api.user");

Route::resource("customers", "CustomerController");
Route::resource("suppliers", "SupplierController");

Route::get('/ajax/categories/search', 'CategoryController@categorySearch')->name("categorySearch");
Route::resource("categories", "CategoryController");
Route::get("/api/category", "CategoryController@apicategory")->name("api.category");

Route::get('/ajax/products/search', 'ProductController@productSearch')->name("productSearch");
Route::resource("products", "ProductController");

Route::resource("stocks", "StockController");

Route::resource("penjualans", "PenjualanController");

Route::resource("pembelians", "PembelianController");
