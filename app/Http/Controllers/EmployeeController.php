<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Job;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Integer;

class EmployeeController extends Controller
{
    public function add(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'salary' => 'required',
            'job_id' => 'required'
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        $employee->job_id = $request->job_id;
        $employee->save();

        return response()->json(['message' => 'Employee has been added successfully'], 201);
    }

    public function setEmployeesProjects(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => [
                'required',
                Rule::exists('employees')->where(function ($query) use ($request) {
                    $query->where('id', $request->employee_id);
                }),
            ],
            'project_id' => [
                'required',
                Rule::exists('projects')->where(function ($query) use ($request) {
                    $query->where('id', $request->project_id);
                }),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 201);
        }

        $employee = Employee::find($request->employee_id);
        $employee->projects()->syncWithoutDetaching($request->project_id);

        return response()->json(['message' => 'Project has been added successfully to Employee'], 201);
    }

    public function getEmployeeProjects($employee)
    {
        $employee = Employee::find($employee);
        return $employee->projects()->get();
    }

    public function getProjectEmployees($project)
    {
        $project = Project::find($project);
        return $project->employee()->get();
    }

    public function getJobEmployees($job)
    {
        $job = Job::find($job);
        return $job->employees()->get();
    }

    public function update(Request $request,$id)
    {
        $employee=Employee::find($id);
        $employee->update($request->all());
        return $employee;
    }
}
