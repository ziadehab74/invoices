<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\invoices;

class TotalInvoices extends Component
{
    public $invoices_count;
    public $Total_invoices;
    public function count()
    {
        $this->Total_invoices = number_format(invoices::sum('Total'), 2);
        $this->invoices_count = invoices::count();
    }
    public function render()
    {
        $this->count();
        return view('livewire.total-invoices');
    }
}
