@extends('layout.app')
@section('title','Employees Index')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0"> Employee Management</h2>
                    <div class="breadcrumb-wrapper">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('errors.index')

    <section id="responsive-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                    </div>
                    <div class="card-datatable">
                        <table class="dt-responsive table" id="emp-table">
                            <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>Employee No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Of Birth</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('custom-styles')
@endpush
@push('custom-scripts')
    <script>
        var ajax_datatable = '{{route('ajax.employee')}}';
    </script>
    <script src="{{asset('js/employee/list.js')}}"></script>

@endpush
