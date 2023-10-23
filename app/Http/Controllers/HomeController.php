<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $results = DB::table('invoices')->select(DB::raw('count(*) as count,Value_status ,SUM(Total) as Total'))->groupBy('Value_status')->get();
            $indexedResults = [];
foreach ($results as $result) {
    $indexedResults[$result->Value_status] = $result;
}
// dd($indexedResults);




        $products = products::count();
        $sections = sections::count();
        $invoices = invoices::count();
        if($indexedResults[2]){
        $Cnot_paied = $indexedResults[2]->count;
        }else{
            $Cnot_paied=0;
        }
        $Cpaied = $indexedResults[1]->count;
        if($indexedResults[3]){
            $Cpartial_paid = $indexedResults[3]->count;
        }else{
            $Cpartial_paid=0;
        }


        if ($Cnot_paied == 0) {
            $not_paied = 0;
        } else {
            $Per_not_paied = $Cnot_paied / ($invoices * 100);
        }
        if ($Cpaied == 0) {
            $Cpaied = 0;
        } else {
            $Per_paied = $Cpaied / ($Cpaied * 100);
        }
        if ($Cpartial_paid == 0) {
            $partial_paid = 0;
        } else {
            $per_partial_paid = $Cpartial_paid / ($Cpartial_paid * 100);
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$Cnot_paied]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$Cpaied]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$Cpartial_paid]
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

        return view('home', compact('indexedResults','invoices', 'Per_not_paied', 'Per_paied', 'per_partial_paid', 'Cpartial_paid', 'Cpaied', 'Cnot_paied', 'chartjs', 'chartjs_2'));
    }
}
