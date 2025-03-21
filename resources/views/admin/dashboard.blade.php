@extends('layout.base')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="dashboard-container py-4">
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card stat-card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Students</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $studentsCount }}</h2>
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
                            <h2 class="text-white">{{ $teachersCount }}</h2>
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
                            <h2 class="text-white">{{ $classroomsCount }}</h2>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-door-closed"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Classrooms for Every Grade</h4>
                        <canvas id="levelsClassroomsChart" class="flot-chart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="card-title">Gender Distribution</h4>

                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="genderChart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Weekly Attendance Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="card-title">Weekly Attendance Overview</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students per Level Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="card-title">Students per Level</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="studentsPerLevelChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Recent Students</h4>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Classroom</th>
                                        <th>Gender</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->classroom->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $student->gender == 'male' ? 'primary' : 'danger' }}">
                                                {{ ucfirst($student->gender) }}
                                            </span>
                                        </td>
                                        <td>{{ $student->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">No recent students found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Recent Teachers</h4>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTeachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->user->email }}</td>
                                        <td>{{ $teacher->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">No recent teachers found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.students.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                        <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <h6>Add Student</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.teachers.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                        <div class="icon-circle bg-success text-white mx-auto mb-3">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                        <h6>Add Teacher</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.classrooms.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                        <div class="icon-circle bg-info text-white mx-auto mb-3">
                                            <i class="fas fa-door-open"></i>
                                        </div>
                                        <h6>Add Classroom</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.subjects.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                        <div class="icon-circle bg-warning text-white mx-auto mb-3">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <h6>Add Subject</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .dashboard-container {
            padding: 20px;
        }
        
        .stat-card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .text-white-50 {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .quick-action-card {
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
        
        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Levels Classrooms Chart
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
            
            // Gender Distribution Chart
            var genderCtx = document.getElementById('genderChart').getContext('2d');
            var genderChart = new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [{{ $maleStudentsCount }}, {{ $femaleStudentsCount }}],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                boxWidth: 15
                            }
                        },
                        title: {
                            display: true,
                            text: 'Student Gender Distribution',
                            padding: {
                                top: 10,
                                bottom: 15
                            }
                        }
                    },
                    layout: {
                        padding: 10
                    },
                    cutout: '60%'
                }
            });
            
            // Weekly Attendance Chart
            var attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            var attendanceData = @json($last7DaysArray);
            
            var attendanceChart = new Chart(attendanceCtx, {
                type: 'bar',
                data: {
                    labels: attendanceData.map(day => day.date),
                    datasets: [
                        {
                            label: 'Present',
                            data: attendanceData.map(day => day.present),
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: '#28a745',
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: 'Late',
                            data: attendanceData.map(day => day.late),
                            backgroundColor: 'rgba(255, 193, 7, 0.7)',
                            borderColor: '#ffc107',
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: 'Absent',
                            data: attendanceData.map(day => day.absent),
                            backgroundColor: 'rgba(220, 53, 69, 0.7)',
                            borderColor: '#dc3545',
                            borderWidth: 1,
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Attendance Status (Last 7 Days)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
            
            // // Students per Level Chart
            var studentsLevelCtx = document.getElementById('studentsPerLevelChart').getContext('2d');
            var studentsPerLevel = @json($studentsPerLevel);
            
            var studentsLevelChart = new Chart(studentsLevelCtx, {
                type: 'bar',
                data: {
                    labels: studentsPerLevel.map(item => item.level),
                    datasets: [{
                        label: 'Number of Students',
                        data: studentsPerLevel.map(item => item.count),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: '#4bc0c0',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Student Distribution by Level'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
                       
        });
    </script>
@endpush
