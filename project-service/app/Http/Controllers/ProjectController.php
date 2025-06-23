<?php 
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        $user = $request->get('user');

        Http::post('http://localhost:8002/api/notify', [
            'email'   => $request->user['email'],
            'message' => 'Project "' . $request->name . '" created successfully',
        ]);


        return Project::create([
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => $user['id'],
        ]);
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->only('name', 'description'));
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
