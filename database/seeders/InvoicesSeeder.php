<?php

namespace Database\Seeders;

use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Database\Seeder;

class InvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1,30) as $range){
            invoices::create([
        'invoice_number'=> $range,
        'invoice_Date'  =>'2023-10-25 11:02:56',
        'Due_date'=>'2023-10-25 11:02:56',
        // 'product'=>'2',
        // 'section_id'=>'2',
        'Amount_collection'=>$range *100,
        'Amount_Commission'=>$range *5,
        'Discount'=>'10',
        'Value_VAT'=>'10',
        'Rate_VAT'=>'10',
        'Total'=>$range *200,
        'Status'=>'مدفوعه',
        'Value_Status'=>'1',
        'Payment_Date'=>'2023-10-25 11:02:56',
        // 'note'=>'لايوجد',
        // 'Payment_Date'=>'2023-10-25 11:02:56',
    ]);
    invoices_details::create([
        'id_Invoice'=>$range,
        'invoice_number'=>$range,
        'product'=>'2',
        'section'=>'2',
        'Status'=>'مدفوعه',
        'Value_Status'=>'1',
                'note'=>'لايوجد',
        'Payment_Date'=>'2023-10-25 11:02:56',
        'note'=>'لايوجد',
        'user'=>'1',
    ]);
}
foreach(range(1,30) as $range){
    invoices::create([
        'invoice_number'=> $range,
        'invoice_Date'  =>'2023-10-25 11:02:56',
        'Due_date'=>'2023-10-25 11:02:56',
        // 'product'=>'2',
        // 'section_id'=>'2',
        'Amount_collection'=>$range *100,
        'Amount_Commission'=>$range *5,
        'Discount'=>'10',
        'Value_VAT'=>'10',
        'Rate_VAT'=>'10',
        'Total'=>$range *200,
        'Status'=>'غير مدفوعه',
        'Value_Status'=>'2',
        'Payment_Date'=>'2023-10-25 11:02:56',
        // 'note'=>'لايوجد',
        // 'Payment_Date'=>'2023-10-25 11:02:56',
    ]);
    invoices_details::create([
        'id_Invoice'=>$range,
        'invoice_number'=>$range,
        'product'=>'2',
        'section'=>'2',
        'Status'=>'غير مدفوعه',
                'Value_Status'=>'2',
                'note'=>'لايوجد',
        'Payment_Date'=>'2023-10-25 11:02:56',
        'note'=>'لايوجد',
        'user'=>'1',
    ]);
}
foreach(range(1,30) as $range){
    invoices::create([
        'invoice_number'=> $range,
        'invoice_Date'  =>'2023-10-25 11:02:56',
        'Due_date'=>'2023-10-25 11:02:56',
        // 'product'=>'2',
        // 'section_id'=>'2',
        'Amount_collection'=>$range *100,
        'Amount_Commission'=>$range *5,
        'Discount'=>'10',
        'Value_VAT'=>'10',
        'Rate_VAT'=>'10',
        'Total'=>$range *200,
        'Status'=>'مدفوعه جزئيا',
        'Value_Status'=>'3',
        'Payment_Date'=>'2023-10-25 11:02:56',
        // 'note'=>'لايوجد',
        // 'Payment_Date'=>'2023-10-25 11:02:56',
    ]);
    invoices_details::create([
        'id_Invoice'=>$range,
        'invoice_number'=>$range,
        'product'=>'2',
        'section'=>'2',
        'Status'=>'مدفوعه جزئيا',
        'Value_Status'=>'3',
                'note'=>'لايوجد',
        'Payment_Date'=>'2023-10-25 11:02:56',
        'note'=>'لايوجد',
        'user'=>'1',
    ]);
}
}
}
