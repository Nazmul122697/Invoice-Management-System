<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::get('/get_all_invoices',[InvoiceController::class,'get_all_invoices']);
route::get('/search_invoices',[InvoiceController::class,'search_invoices']);
route::get('/create_invoices',[InvoiceController::class,'create_invoices']);
route::post('/add_invoice',[InvoiceController::class,'add_invoice']);
route::post('/invoice_update/{id?}',[InvoiceController::class,'update_invoice']);
route::get('/show/invoice/{id?}',[InvoiceController::class,'showInvoice']);
route::get('/get_invoice_data_for_edit/{id?}',[InvoiceController::class,'editInvoice']);
route::get('/invoice_item_delete/{id?}',[InvoiceController::class,'deleteInvoiceItem']);

// customers 
route::get('/customers',[CustomerController::class,'allCustomers']);

// products 
route::get('/products',[ProductController::class,'allproducts']);
