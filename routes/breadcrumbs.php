<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


// ----------------------------------------------------------------------------
//Program
Breadcrumbs::for('program', function (BreadcrumbTrail $trail) {
    $trail->push('Program', route('program.index'));
});
// Home > Blog
Breadcrumbs::for('detail_program', function (BreadcrumbTrail $trail, $pro) {
    $trail->parent('program');
    $trail->push($pro->nama, route('program.show', $pro));
});

// ----------------------------------------------------------------------------
// Payment database
Breadcrumbs::for('payment', function (BreadcrumbTrail $trail) {
    $trail->parent('program');
    $trail->push('DBPayment', route('payment.index'));
});

Breadcrumbs::for('detail_db', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('payment');
    $nama = ucfirst($data['name']);
    $trail->push($nama, route('payment.show', $data['name']));
});

Breadcrumbs::for('payment_create', function (BreadcrumbTrail $trail) {
    $trail->parent('payment');
    $trail->push('Create', route('payment.create'));
});

// ----------------------------------------------------------------------------

// Pelanggan database
Breadcrumbs::for('pelanggan', function (BreadcrumbTrail $trail) {
    $trail->parent('program');
    $trail->push('Pelanggan', route('pelanggan.index'));
});

Breadcrumbs::for('detail_pelanggan', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('pelanggan');
    $nama = ucfirst($data['name']);
    $trail->push($nama, route('pelanggan.show', $data['name']));
});

Breadcrumbs::for('create_pelanggan', function (BreadcrumbTrail $trail) {
    $trail->parent('pelanggan');
    $trail->push('Create', route('pelanggan.create'));
});
// ----------------------------------------------------------------------------

// Payment datawarehouse
Breadcrumbs::for('dwpayment', function (BreadcrumbTrail $trail) {
    $trail->parent('program');
    $trail->push('DWPayment', route('paymentdw.index'));
});

Breadcrumbs::for('detail_dw', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('dwpayment');
    $nama = ucfirst($data['name']);
    $trail->push($nama, route('paymentdw.show', $data['name']));
});

Breadcrumbs::for('dwpayment_create', function (BreadcrumbTrail $trail) {
    $trail->parent('dwpayment');
    $trail->push('Create', route('paymentdw.create'));
});
// ----------------------------------------------------------------------------

// Breadcrumbs::for('detail', function (BreadcrumbTrail $trail, $detail) {
//     $trail->parent('payment');
//     $trail->push($detail['name'], route('payment.show', $detail));
// });

