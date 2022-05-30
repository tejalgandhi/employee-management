@extends('layout.app')
@section('title','404')
@section('content')


    <section class="py-20">
        <img class="rounded mx-auto d-block" src="{{asset('frontend/error2.png')}}" alt="" width="500px" height="500px">
        <div class="container px-4 mx-auto text-center">

            <span class="text-4xl font-bold font-heading text-danger">Error 404</span>
            <h2 class="mb-2 text-4xl font-bold font-heading">Something went wrong!</h2>
            <p class="mb-6 text-blueGray-400">Sorry, but we are unable to open this page.</p>
            <div><a class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 text-xs text-white text-center font-semibold leading-none rounded bg-red-500 hover:bg-red-700" href="{{url('/')}}">Go back to Homepage</a>

            </div>
            <span class="text-4xl font-bold font-heading text-danger"> <a class="block sm:inline-block py-4 px-8 text-xs text-blueGray-500 hover:text-blueGray-800 text-center font-semibold leading-none bg-blueGray-50
                 hover:bg-blueGray-100 rounded" href="{{ url()->previous() }}">
                    Try Again</a></span>
        </div>
    </section>


@endsection