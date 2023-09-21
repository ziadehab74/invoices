<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Models\invoices;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoices_attachements;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Notifications\AddInvoice;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\MyEventClass;
use App\Models\invoice_attachments;
use App\Models\products;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = invoices::leftjoin('invoices_details', 'invoices.id', '=', 'invoices_details.id')
            ->leftjoin('products', 'invoices_details.product', '=', 'products.id')
            ->leftjoin('sections', 'invoices_details.section', '=', 'sections.id')
            ->select(
                'invoices.id',
                'products.Product_name',
                'sections.section_name',
                'invoices.invoice_number',
                'invoices.invoice_Date',
                'invoices.Due_date',
                'invoices.Discount',
                'invoices.Rate_VAT',
                'invoices.Value_VAT',
                'invoices.Total',
                'invoices.Status',
                'invoices.Value_Status'
            )
            ->get();
        // dd($invoices);


        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $sections = sections::all();
        $invoice_id = invoices::latest()->first();
        if ($invoice_id == null) {
            $invoice_id = 1;
        } else if ($invoice_id == '1') {
            $invoice_id == 1;
        } else {
            $invoice_id = $invoice_id->id + 1;
        }
        return view('invoices.add-invoices', compact('sections', 'invoice_id'));
    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        // dd($request);
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::first();
        // Notification::send($user, new AddInvoice($invoice_id));

        //   $user = User::get();
        $invoices = invoices::latest()->first();
        //  Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));



        // $validated = $request->validate([
        //     'invoice_Date'=>'required',
        //     'Due_date' => 'required|date|date_format:Y-m-d|before:invoice_Date',
        //        ]);
        //        return redirect('invoices.add-invoices');



        //event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::leftjoin('invoices_details', 'invoices.id', '=', 'invoices_details.id')
        ->leftjoin('products', 'invoices_details.product', '=', 'products.id')
        ->leftjoin('sections', 'invoices_details.section', '=', 'sections.id')
        ->select(
            'invoices.id',
            'products.Product_name',
            'sections.Section_name',
            'invoices_details.product',
            'invoices_details.section',
            'invoices.invoice_number',
            'invoices.invoice_Date',
            'invoices.Due_date',
            'invoices.Discount',
            'invoices.Rate_VAT',
            'invoices.Value_VAT',
            'invoices.Total',
            'invoices.Status',
            'invoices.Value_Status'
        )
        ->where('id_Invoice', $id)->first();
        // dd($invoices);
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $invoices_details = invoices_details::where('id_Invoice', $id)->first();

        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices', 'invoices_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices_details = invoices_details::findOrFail($request->invoice_id);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,

            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        $invoices_details->update([
            'product' => $request->product,
            'Section' => $request->Section,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;


        // if (!$id_page == 2) {

        //     if (!empty($Details->invoice_number)) {

        //         Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        //     }

        //     $invoices->forceDelete();
        //     session()->flash('delete_invoice');
        //     return redirect('/invoices');
        // } else {

        //     $invoices->delete();
        //     session()->flash('archive_invoice');
        //     return redirect('/Archive');
        // }
    }



    public function Status_Update($id, Request $request)
    {
        $invoices = invoices::findOrFail($id);
        $invoices_Details=invoices_details::findOrFail($id);
        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            $invoices_Details->update([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                // 'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            $invoices_Details->update([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                // 'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }


    public function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoices::where('Value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status', 3)->get();
        return view('invoices.invoices_Partial', compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = invoices::leftjoin('invoices_details', 'invoices.id', '=', 'invoices_details.id')
            ->leftjoin('products', 'invoices_details.product', '=', 'products.id')
            ->leftjoin('sections', 'invoices_details.section', '=', 'sections.id')
            ->select(
                'invoices.id',
                'products.Product_name',
                'sections.Section_name',
                'invoices.invoice_number',
                'invoices.invoice_Date',
                'invoices.Due_date',
                'invoices.Discount',
                'invoices.Rate_VAT',
                'invoices.Value_VAT',
                'invoices.Total',
                'invoices.Status',
                'invoices.Value_Status'
            )
            ->where('invoices.id', $id)->first()
            ->first();

        // dd($invoices);
        return view('invoices.Print_invoice', compact('invoices'));
    }

    // public function export()
    // {


    //     return Excel::download(new InvoicesExport, 'invoices.xlsx');

    // }


    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }


    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification) {

            return $notification->data['title'];
        }
    }
}
