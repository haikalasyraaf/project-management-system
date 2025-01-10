<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Project $project)
    {
        $expenses = Expense::where('project_id', $project->id)->paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['link' => "/projects/$project->id/expenses", 'name' => __('Expense')],
            ['name' => __('List')]
        ];

        return view('expense.index', compact('breadcrumbs', 'project', 'expenses'));
    }

    public function create(Project $project)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['link' => "/projects/$project->id/expenses", 'name' => __('Expense')],
            ['name' => __('Create')]
        ];

        return view('expense.create', compact('breadcrumbs', 'project'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'description'  => 'required|max:5000',
            'date'         => 'required|date',
            'amount'       => 'required|numeric|min:0',
            'type'         => 'required|in:travel,equipment,miscellaneous',
            'attachment'   => 'file|mimes:jpeg,png,pdf,docx|max:2048',
        ]);

        $expense = new Expense();
        $expense->project_id        = $project->id;
        $expense->description       = $request->description;
        $expense->date              = $request->date;
        $expense->type              = $request->type;
        $expense->amount            = $request->amount;
        $expense->created_by        = Auth::user()->id;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attachments', $fileName, 'public');
        
            $expense->file_path = $path;
        }
        $expense->save();

        return response()->json(['message' => 'success']);
    }

    public function edit(Project $project, Expense $expense)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['link' => "/projects/$project->id/expenses", 'name' => __('Expense')],
            ['name' => __('Edit')]
        ];

        return view('expense.edit', compact('breadcrumbs', 'project', 'expense'));
    }

    public function update(Request $request, Project $project, Expense $expense)
    {
        $request->validate([
            'description'  => 'required|max:5000',
            'date'         => 'required|date',
            'amount'       => 'required|numeric|min:0',
            'type'         => 'required|in:travel,equipment,miscellaneous',
            'attachment'   => 'file|mimes:jpeg,png,pdf,docx|max:2048',
        ]);

        $expense->description       = $request->description;
        $expense->date              = $request->date;
        $expense->type              = $request->type;
        $expense->amount            = $request->amount;
        if ($request->hasFile('attachment')) {
            if (!is_null($expense->file_path) && Storage::exists('public/' . $expense->file_path)) {
                Storage::delete('public/' . $expense->file_path);
            }

            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attachments', $fileName, 'public');

            $expense->file_path = $path;
        }
        $expense->save();

        return response()->json(['message' => 'success']);
    }

    public function destroy(Project $project, Expense $expense)
    {
        $expense = Expense::find($expense->id);
        $expense->delete();

        return redirect()->back();
    }

    public function download(Project $project, Expense $expense)
    {
        $filePath = storage_path('app/public/' . $expense->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404, 'File not found');
    }

    public function approve(Project $project, Expense $expense)
    {
        $expense->review_status = 1;
        $expense->reviewed_by = Auth::user()->id;
        $expense->save();

        return response()->json(['message' => 'success']);
    }

    public function reject(Project $project, Expense $expense)
    {
        $expense->review_status = 2;
        $expense->reviewed_by = Auth::user()->id;
        $expense->save();

        return response()->json(['message' => 'success']);
    }
}
