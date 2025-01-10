<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/invoices", 'name' => __('Invoice')],
            ['name' => __('List')]
        ];

        return view('invoice.index', compact('breadcrumbs', 'invoices'));
    }

    public function create()
    {
        $projects = Project::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/invoices", 'name' => __('Invoice')],
            ['name' => __('List')]
        ];

        return view('invoice.create', compact('breadcrumbs', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'   => 'required',
            'date'         => 'required|date|before_or_equal:due_date',
            'due_date'     => 'required|date|after_or_equal:date',
            'description'  => 'max:5000',
            'amount'       => 'required|numeric|min:0'
        ]);

        $project = Project::find($request->project_id);

        $invoice = new Invoice();
        $invoice->project_id    = $project->id;
        $invoice->date          = $request->date;
        $invoice->number        = InvoiceService::generateInvoiceNumber();
        $invoice->description   = $request->description;
        $invoice->amount        = $request->amount;
        $invoice->due_date      = $request->due_date;
        $invoice->created_by    = Auth::user()->id;
        $invoice->save();

        return response()->json(['message' => 'success']);
    }

    public function show(Invoice $invoice)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/invoices", 'name' => __('Invoice')],
            ['name' => __('List')]
        ];

        return view('invoice.show', compact('breadcrumbs', 'invoice'));
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->status = 1;
        $invoice->save();

        return redirect()->back();
    }

    public function destroy(Invoice $invoice)
    {
        $invoice = Invoice::find($invoice->id);
        $invoice->delete();

        return redirect()->back();
    }
}
