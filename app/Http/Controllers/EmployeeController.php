<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('employee.index');
    }

    public function employeeAjax(Request $request)
    {

        $emp = Employee::orderBy('id', 'DESC');

        $table = DataTables::of($emp)
            ->editColumn('image', function ($emp) {
                if(!empty($emp->image)) {
                    //$path =  asset(HealthArticle::FILE_PATH . $emp->image);
                    $path =  $emp->image;
                    return '<img src="' . $path . '" height="50px" width="50px">';

                }
                return '';
            })
            ->editColumn('action', function ($emp) {


                    $edit_route = route('employee.edit', $emp->id);
                    $delete_route = route('employee.destroy', $emp->id);

                $html = '<a href="'.$edit_route.'">
                            <i class="fa fa-edit "></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteMedicine" data-href="'.$delete_route.'">
                            <i class="fa fa-trash"></i>
                        </a>';
                return $html;
            })
            ->rawColumns(['action','image'])
            ->make(true);
        return $table;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
