<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Project $project)
    {
        $expenses = Expense::where('project_id', $project->id)->paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "projects", 'name' => __('Project')],
            ['link' => "expenses", 'name' => __('Expense')],
            ['name' => __('List')]
        ];

        return view('expense.index', compact('breadcrumbs', 'project', 'expenses'));
    }

    public function create(Project $project)
    {
        return view('expense.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $expense = new Expense();
        $expense->project_id        = $project->id;
        $expense->description       = $request->description;
        $expense->date              = $request->date;
        $expense->type              = $request->type;
        $expense->amount            = $request->amount;
        $expense->created_by        = Auth::user()->id;
        $expense->save();

        return response()->json(['message' => 'success']);
    }

    public function edit(Project $project, Expense $expense)
    {
        return view('expense.edit', compact('project', 'expense'));
    }

    public function update(Request $request, Project $project, Expense $expense)
    {
        $expense->description       = $request->description;
        $expense->date              = $request->date;
        $expense->type              = $request->type;
        $expense->amount            = $request->amount;
        $expense->save();

        return response()->json(['message' => 'success']);
    }

    public function destroy(Project $project, Expense $expense)
    {
        $expense = Expense::find($expense->id);
        $expense->delete();

        return redirect()->back();
    }
}
