<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_Invoice',
        'product',
        'invoice_number',
        'Section',
        'Status',
        'Value_Status',
        'Payment_Date',
        'note',
        'user',
        'created_at',
        'updated_at',

    ];
    public function section()
    {
    return $this->hasMany('App\Models\sections');
    }
    public function product()
    {
    return $this->hasMany('App\Models\products');
    }
}
