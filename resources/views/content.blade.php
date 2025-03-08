@extends('layout.base')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card-body">
                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <i class="fas fa-user-graduate fa-7x"></i>
                        <h5 class="mt-3 mb-1">Number of students</h5>
                        <p class="m-0">{{ count($students) }}</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-user-graduate fa-7x"></i>
                        <h5 class="mt-3 mb-1">Number of teachers</h5>
                        <p class="m-0">{{ count($teachers) }}</p>
                    </div>
                    <div class="text-center">
                        <i class="fa-solid fa-school fa-7x"></i>
                        <h5 class="mt-3 mb-1">Number of levels</h5>
                        <p class="m-0">{{ count($levels) }}</p>
                    </div>
                    <div class="text-center">
                        <i class="fa-solid fa-users fa-7x"></i>
                        <h5 class="mt-3 mb-1">Number of classrooms</h5>
                        <p class="m-0">{{ count($classrooms) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
