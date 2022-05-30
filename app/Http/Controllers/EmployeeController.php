<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('search')) && !empty($request->get('search')['value'])) {
                    $search =$request->get('search')['value'];
                    $query->where(function ($qu) use($query,$request,$search){
                        $qu->orwhere('name','like', "{$search}%");
                        $qu->orwhere('address','like', "{$search}%");
                        $qu->orwhere('employee_no','like', "{$search}%");
                        $qu->orwhere('email','like', "{$search}%");
                    });
                }

            })
            ->editColumn('employee_no', function ($emp) {
                if (!empty($emp->employee_no)) {

                    return $emp->employee_no;

                }
                return '';
            })
            ->editColumn('image', function ($emp) {
                if (!empty($emp->image)) {
                    $path = asset(Employee::STORE_FILE_PATH . $emp->image);
                    return '<img src="' . $path . '" height="50px" width="50px">';

                }
                return '';
            })
            ->editColumn('action', function ($emp) {

                $edit_route = route('employee.edit', $emp->id);
                $delete_route = route('employee.destroy', $emp->id);

                $html = '<a href="' . $edit_route . '">
                            <i class="fa fa-edit "></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteEmp" data-href="' . $delete_route . '">
                            <i class="fa fa-trash"></i>
                        </a>';
                return $html;
            })
            ->rawColumns(['action', 'image'])
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
        return view('employee.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $route = 'employee.index';;
            $rules = array(
                'image' => 'mimes:jpeg,jpg,png|required|max:10000', // max 10000kb
                'email' => 'required|email|unique:employees'

            );

            $messages = array(
                'image.required' => 'Image Field is required.',
                'image.image' => 'The type of the uploaded file should be an image.',
                'image.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
            );
            // Now pass the input and rules into the validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check to see if validation fails or passes
            if ($validator->fails()) {
                // Redirect or return json to frontend with a helpful message to inform the user
                // that the provided file was not an adequate type
                return redirect()->route($route)->withInput()->with('error', $validator->errors()->first());
            }
            if ($request->hasfile('image')) {

                $file = $request->file('image');
                $destinationPath = Employee::STORE_FILE_PATH;

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $user_image = time() . $file->getClientOriginalName();
                $file->move($destinationPath, $user_image);
                $data = $user_image;
            }
            Employee::create([
                'employee_no' => get_employee_no(),
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'dob' => $request->dob,
                'image' => !empty($data) ? $data : NULL,
            ]);
            $message = 'Employee stored successfully.';
            return redirect()->route($route)->with('success', $message);


        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $emp_data = Employee::find($id);
        return view('employee.edit', compact('emp_data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        try {
            $data = $request->old_image;

            $route = 'employee.index';
            $rules = array(
                'email' => 'required|email|unique:employees,email,'.$id

            );

            $messages = array(
                'email.required' => 'Email Field is required.',
            );
            // Now pass the input and rules into the validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check to see if validation fails or passes
            if ($validator->fails()) {
                // Redirect or return json to frontend with a helpful message to inform the user
                // that the provided file was not an adequate type
                return redirect()->route($route)->withInput()->with('error', $validator->errors()->first());
            }
            if ($request->hasfile('image')) {
                $rules = array(
                    'image' => 'mimes:jpeg,jpg,png|required|max:10000', // max 10000kb
                );

                $messages = array(
                    'image.required' => 'Image Field is required.',
                    'image.image' => 'The type of the uploaded file should be an image.',
                    'image.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
                );
                // Now pass the input and rules into the validator
                $validator = Validator::make($request->all(), $rules, $messages);

                // Check to see if validation fails or passes
                if ($validator->fails()) {
                    // Redirect or return json to frontend with a helpful message to inform the user
                    // that the provided file was not an adequate type
                    return redirect()->route($route)->withInput()->with('error', $validator->errors()->first());
                }
                $file = $request->file('image');
                $destinationPath = Employee::STORE_FILE_PATH;

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $user_image = time() . $file->getClientOriginalName();
                $file->move($destinationPath, $user_image);
                @unlink(url(asset($request->old_image)));
                $data = $user_image;
            }
            Employee::where('id', $id)->update([
                'employee_no' => get_employee_no(),
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'dob' => $request->dob,
                'image' => !empty($data) ? $data : NULL,
            ]);
            $message = 'Employee updated successfully.';
            return redirect()->route($route)->with('success', $message);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = Employee::where('id',$id)->first();
        if($data === NULL)
        {
            return response()->json(['message' => "Employee Not Found"], 500);
        }

        if(!empty($data)){
            $filePath = asset(Employee::STORE_FILE_PATH . '/' .$data->image);
            @unlink(url($filePath));
        }
        $data->delete();

        return response()->json(['message' => "Employee deleted successfully."]);
    }
}
