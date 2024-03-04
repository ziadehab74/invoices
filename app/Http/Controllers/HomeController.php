<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $paid_invoices = invoices::where('Value_Status', '1')->count();
        $paid_Percntage_invoices = $paid_invoices  * 100 ;
        $Total_paid_invoices=number_format(invoices::where('Value_Status','1')->sum('Total'),2);


        $unpaid_invoices = invoices::where('Value_Status', '2')->count();
        $unpaid_Percntage_invoices = $unpaid_invoices* 100;
        $Total_unpaid_invoices=number_format(invoices::where('Value_Status','2')->sum('Total'),2);


        $Partially_paid_invoices = invoices::where('Value_Status', '3')->count();
        $Partially_paid_invoices_percntage = $Partially_paid_invoices* 100;
        $Total_Partially_invoices=number_format(invoices::where('Value_Status','3')->sum('Total'),2);


        $products = products::count();
        $sections = sections::count();

        $invoices_count=invoices::count();
        $Total_invoices=number_format(invoices::sum('Total'),2);

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 240])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$unpaid_invoices]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$paid_invoices]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$Partially_paid_invoices]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 476, 'height' => 277])
            ->labels(['المنتجات', 'الأقسـام'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214'],
                    'data' => [$products, $sections]
                ]
            ])
            ->options([]);

        return view('home', compact( 'paid_invoices','Total_paid_invoices','Total_unpaid_invoices',
        'Total_Partially_invoices',
        'unpaid_invoices',
        'Partially_paid_invoices','chartjs',
        'chartjs_2','invoices_count',
        'Total_invoices'));
    }
}
