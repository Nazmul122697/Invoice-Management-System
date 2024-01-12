<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'invoice_number', 'date', 'due_date', 'sub_total','total','reference','discount','terms_and_condition'];

    public function Customer(){
        return $this->belongsTo(Customer::class); //1 invoice belongs to 1 customer
    }
    public function Invoiceitem(){
        return $this->hasMany(InvoiceItem::class); //1 invoice has many invoice items`
    }
}
