<?php

namespace App\Http\Controllers;

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
        // $email = request("email");
        // $password = request("password");
        // $results = \App\Models\invoices::select(\DB::raw("count(*) as total"), 'Value_Status')->groupBy('Value_Status')->get()->keyBy('Value_Status');
        // dd($results->toArray());
        $result1 = \App\Models\invoices::where('Value_Status', '1')->count();
        $result2 = \App\Models\invoices::where('Value_Status', '1')->count() * 100;
        if ($result2 == 0 || $result1 == 0) {
            $result3 = '0';
        } else {
            $result3 = $result1 / $result2;
        }
        $result4 = \App\Models\invoices::where('Value_Status', '2')->count();
        $result5 = \App\Models\invoices::where('Value_Status', '2')->count() * 100;
        if ($result4 == 0 || $result5 == 0) {
            $result6 = '0';
        } else {
            $result6 = $result4 / $result5;
        }


        $result7 = \App\Models\invoices::where('Value_Status', '3')->count();
        $result8 = \App\Models\invoices::where('Value_Status', '3')->count() * 100;
        if ($result7 == 0 || $result8 == 0) {
            $result9 = '0';
        } else {
            $result9 = $result7 / $result8;
        }
        $products = products::count();
        $sections = sections::count();

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$result7]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$result4]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$result1]
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

        return view('home', compact('result3', 'result6','result9', 'chartjs', 'chartjs_2'));




        // ExampleController.php



        // example.blade.php







    }
}
