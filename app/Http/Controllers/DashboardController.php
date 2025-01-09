<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $invoices = Invoice::all();
        $expenses = Expense::all();

        return view('dashboard', compact('projects', 'invoices', 'expenses'));
    }
}
