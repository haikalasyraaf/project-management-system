<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['name' => __('List')]
        ];

        return view('project.index', compact('breadcrumbs', 'projects'));
    }

    public function create()
    {
        $users = User::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['name' => __('Create')]
        ];

        return view('project.create', compact('breadcrumbs', 'users'));
    }

    public function store(Request $request)
    {
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date  = $request->start_date;
        $project->end_date    = $request->end_date;
        $project->budget      = $request->budget;
        $project->status      = $request->status;
        $project->created_by  = Auth::user()->id;
        $project->save();

        $project->users()->attach($request->assign_user);

        return redirect()->route('project.index');
    }

    public function edit(Project $project)
    {
        $users = User::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/projects", 'name' => __('Project')],
            ['name' => __('Edit')]
        ];

        return view('project.edit', compact('breadcrumbs', 'project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date  = $request->start_date;
        $project->end_date    = $request->end_date;
        $project->budget      = $request->budget;
        $project->status      = $request->status;
        $project->created_by  = Auth::user()->id;
        $project->save();

        $project->users()->detach();
        $project->users()->attach($request->assign_user);

        return redirect()->route('project.index');
    }

    public function destroy(Project $project)
    {
        $project = Project::find($project->id);
        $project->delete();

        return redirect()->back();
    }
}
