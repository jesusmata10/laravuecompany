<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'employees.department_id', 'departments.name as department')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->paginate(10);

        return Inertia::render('Employees/Index', ['departments' => $departments, 'employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employees/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $employee = new Employee($request->all());
        $employee->save();

        return redirect('employees');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return  Inertia::render('employees', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);

        $employee->update($request->all());

        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect('employees');
    }

    public function EmployeeByDepartment()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
        ->join('departments', 'departments.id','=', 'employees.department_id')
        ->groupBy('departments.name')->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);


    }

    public function reports()
    {
        $departments = Department::all();
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name as department')
        ->join('departents', 'departments.id', '=', 'employees.department_id')
        ->get();

        return Inertia::render('Employees/Report', ['employees' => $employees, 'departments' => $departments]);
    }
}
