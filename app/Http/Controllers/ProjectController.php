<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function add(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique'
        ]);

        $job = new Project();
        $job->name = $request->name;
        $job->save();

        return response()->json(['message' => 'Project has been added successfully'], 201);
    }
}
