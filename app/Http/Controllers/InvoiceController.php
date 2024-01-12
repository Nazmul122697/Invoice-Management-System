<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;

class InvoiceController extends Controller
{
    public function get_all_invoices()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'asc')->get();
        return response()->json([
            'invoices' => $invoices,
        ], 200);
    }

    public function search_invoices(Request $request)
    {
        $search = $request->get('list');
        if ($search != null) {
            $invoices = Invoice::with('customer')->where('id', 'like', '%' . $search . '%')->get();
            return response()->json([
                'invoices' => $invoices,
            ], 200);
        } else {
            return $this->get_all_invoices();
        }
    }


    // add new Invoice 
    public function create_invoices(Request $request)
    {
        $counter = Counter::where('key', 'Invoice')->first();
        $random = Counter::where('key', 'Invoice')->first();

        $invoice = Invoice::orderBy('id', 'desc')->first();
        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value + 1;
        }


        $formData = [
            'invoice_number' => $counters,
            'customer_id' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'terms_and_condition' => 'default terms and condition',
            'discount' => 0,
            'items' => [
                'product_id' => null,
                'product' => null,
                'unit_price' => 0,
                'quantity' => 1
            ]
        ];

        return response()->json($formData);
    }



    public function add_invoice(Request $request){
        $invoice_item = $request->input('invoice_item');

        $invoiceData['sub_total'] = $request->input('sub_total');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['total'] = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['invoice_number'] = $request->input('invoice_number');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['terms_and_condition'] = $request->input('terms_and_condition');
        $invoice = Invoice::create($invoiceData);

        foreach(json_decode($invoice_item) as $item){
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['unit_price'] = $item->unit_price;
            $itemData['quantity'] = $item->quantity;

            InvoiceItem::create($itemData);
        }
    }

    public function showInvoice($id) {
        $invoice = Invoice::with('customer','invoiceitem.product')->find($id);
        return response()->json([
            'invoice' => $invoice,
        ],200);
    }

    public function editInvoice($id){
        $invoiceData = Invoice::with('customer','invoiceitem.product')->find($id);
        return response()->json([
            'invoice' => $invoiceData,
        ],200);
    }
}
