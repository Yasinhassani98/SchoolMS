@extends('layout.base')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="dashboard-container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card stat-card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Students</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $studentsNumber }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-user-graduate"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card stat-card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Teachers</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $teachersNumber }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-chalkboard-teacher"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card stat-card gradient-8">
                    <div class="card-body">
                        <h3 class="card-title text-white">Levels</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ count($levels) }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-school"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card stat-card gradient-7">
                    <div class="card-body">
                        <h3 class="card-title text-white">Classrooms</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $classroomsNumber }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-door-closed"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card chart-card p-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Classrooms for Every Grade</h4>
                        <canvas id="levelsClassroomsChart" class="flot-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .stat-card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('levelsClassroomsChart').getContext('2d');
            var levelsClassroomsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($levels->pluck('name')),
                    datasets: [{
                        label: 'Classrooms Number',
                        data: @json($levels->pluck('classrooms_count')),
                        backgroundColor: 'rgba(102, 126, 234, 0.6)',
                        borderColor: '#667eea',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Classrooms Distribution by Grade',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
