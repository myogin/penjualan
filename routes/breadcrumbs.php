<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Supplier
Breadcrumbs::for('supplier', function ($trail) {
    $trail->parent('home');
    $trail->push('Supplier', route('suppliers.index'));
});
// Home > User
Breadcrumbs::for('user', function ($trail) {
    $trail->parent('home');
    $trail->push('User', route('users.index'));
});

// Home > Stok
Breadcrumbs::for('stock', function ($trail) {
    $trail->parent('home');
    $trail->push('Stok', route('stocks.index'));
});

// Home > Products
Breadcrumbs::for('product', function ($trail) {
    $trail->parent('home');
    $trail->push('Products', route('products.index'));
});

// Home > Penjualan
Breadcrumbs::for('penjualan', function ($trail) {
    $trail->parent('home');
    $trail->push('Penjualan', route('penjualans.index'));
});

// Home > Penjualan > Tambah
Breadcrumbs::for('transaksi', function ($trail) {
    $trail->parent('penjualan');
    $trail->push('Transaksi Jual', route('penjualans.create'));
});

// Home > Penjualan
Breadcrumbs::for('pembelian', function ($trail) {
    $trail->parent('home');
    $trail->push('Pembelian', route('pembelians.index'));
});

// Home > Penjualan > Tambah
Breadcrumbs::for('transaksi-beli', function ($trail) {
    $trail->parent('pembelian');
    $trail->push('Transaksi Beli', route('pembelians.create'));
});


// Home > Customer
Breadcrumbs::for('customer', function ($trail) {
    $trail->parent('home');
    $trail->push('Customer', route('customers.index'));
});

// Home > Category
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('home');
    $trail->push('Category', route('categories.index'));
});
