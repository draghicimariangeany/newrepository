<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function add(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique'
        ]);

        $job = new Job();
        $job->name = $request->name;
        $job->save();

        return response()->json(['message' => 'Job has been added successfully'], 201);
    }

    public function update(Request $request,$id)
    {
        $job=Job::find($id);
        $job->update($request->all());
        return $job;
    }
}
