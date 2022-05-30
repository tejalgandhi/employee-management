@extends('layout.app')
@section('title','Employee')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Employee</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item active">{{isset($emp_data) ? 'Edit' : 'Add'}}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Validation -->
        <section class="bs-validation">
            <div class="row">
                <!-- jQuery Validation -->
                @include('errors.index')
                <div class="col-md-12 col-12">
                    <form id="emp-form" enctype="multipart/form-data"
                          action="{{isset($emp_data)? route('employee.update', $id)  : route('employee.store')}}"
                          method="post">
                        {{ @csrf_field() }}
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">{{isset($emp_data) ? 'Edit Employee' : 'Add Employee'}}</h2>
                            </div>
                            <div class="card-body">
                                <input type="hidden" value="{{isset($emp_data)?$emp_data->id:'0'}}" id="id" name="id"/>


                                <div class="mb-1">
                                    <label class="form-label" for="name">Employee Name</label>
                                    <input type="text" class="form-control name "
                                           value="{{isset($emp_data)?($emp_data->name):old('name')}}" id="name"
                                           placeholder="Employee Name" name="name"/>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="name">Address</label>
                                    <textarea name="address" class="form-control address" id="address"
                                              placeholder="Address">{{isset($emp_data)?($emp_data->address):old('address')}}</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email-id-icon" name="email" class="form-control"
                                               value="{{(isset($emp_data))?$emp_data->email:old('email')}}"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="mobile_number">Mobile Number</label>

                                        <input type="number" id="contact-info-vertical" class="form-control"
                                               name="mobile_number"
                                               value="{{(isset($emp_data))?$emp_data->mobile_number:old('mobile_number')}}"
                                               placeholder="Mobile Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label">Select Date of Birth</label>
                                        <input type="text" class="form-control  chng_date" placeholder="Select Date" id="dob" value="{{(isset($emp_data))?$emp_data->dob:old('dob')}}" name="dob"  />
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="image">Employee Image</label>
                                    <input type="file" class="form-control profile_pic " id="image" name="image"
                                           accept="image/*"/>
                                    @if(isset($emp_data) && !empty($emp_data->image))
                                        <input type="hidden" class="form-control name "
                                               value="{{isset($emp_data)?($emp_data->image):NULL}}" id="image"
                                               placeholder="image" name="old_image"/>

                                        <img src="{{asset(\App\Models\Employee::STORE_FILE_PATH . $emp_data->image)}}" width="100px">
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 text-center">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit
                                </button>

                                <a href="{{route('employee.index')}}" class="btn btn-danger">Cancel</a>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /jQuery Validation -->
            </div>
        </section>
        <!-- /Validation -->
    </div>
@endsection
@push('custom-styles')
    <style>
        .help-block{
            color:red;
        }
    </style>
@endpush
@push('custom-scripts')
    {!! JsValidator::formRequest(\App\Http\Requests\EmployeeRequest::class,'#emp-form') !!}
    <script>
        $(document).ready(function () {

            $('#dob').flatpickr({
                altInput: true,
                dateFormat: "Y-m-d",
                maxDate: "today"
            });
        })
    </script>
@endpush