<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\invoices;
use App\Models\sections;

class TotalInvoices extends Component
{
    public $invoices_count;
    public $Total_invoices;
    public $Total_unpaid_invoices;
    public $unpaid_invoices;
    public $Total_paid_invoices;
    public $paid_invoices;
    public $Total_Partially_invoices;
    public $Partially_paid_invoices;
    public $chartjs;
    public $Partially_paid_invoices_percntage;
    public $paid_Percntage_invoices;
    public $unpaid_Percntage_invoices;
    public function count()
    {
        $this->paid_invoices = invoices::where('Value_Status', '1')->count();
        $this->paid_Percntage_invoices = $this->paid_invoices  * 100;
        $this->Total_paid_invoices = number_format(invoices::where('Value_Status', '1')->sum('Total'), 2);


        $this->unpaid_invoices = invoices::where('Value_Status', '2')->count();
        $this->unpaid_Percntage_invoices = $this->unpaid_invoices * 100;
        $this->Total_unpaid_invoices = number_format(invoices::where('Value_Status', '2')->sum('Total'), 2);


        $this->Partially_paid_invoices = invoices::where('Value_Status', '3')->count();
        $this->Partially_paid_invoices_percntage = $this->Partially_paid_invoices * 100;
        $this->Total_Partially_invoices = number_format(invoices::where('Value_Status', '3')->sum('Total'), 2);


        // $products = products::count();
        // $this->sections = sections::count();

        $this->invoices_count = invoices::count();
        $this->Total_invoices = number_format(invoices::sum('Total'), 2);

        $this->Total_invoices = number_format(invoices::sum('Total'), 2);
        $this->invoices_count = invoices::count();


    }

    public function render()
    {
        $this->count();
        return view('livewire.total-invoices');
    }
}
