<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $guarded = [];

   public function section()
   {
   return $this->belongsTo('App\Models\sections');
   }
   public function invoice_details()
   {
   return $this->belongsTo('App\Models\invoice_details');
   }
}
