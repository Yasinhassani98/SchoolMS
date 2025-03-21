@extends('layout.base')
@section('title', 'Teacher Dashboard')
@section('content')

<div class="dashboard-container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body d-flex align-items-center">
                    <div class="welcome-avatar me-4">
                        <div class="avatar-circle">
                            <span class="avatar-initials">{{ substr($teacher->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="welcome-text">
                        <h4 class="mb-1">Welcome back, {{ $teacher->name }}!</h4>
                        <p class="text-muted mb-0">{{ now()->format('l, F d, Y') }}</p>
                    </div>
                    {{-- <div class="ms-auto d-none d-md-block">
                        <a href="{{ route('teacher.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
            <div class="card stat-card gradient-1 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white mb-0">My Students</h6>
                            <h2 class="text-white mt-2 mb-0">{{ $studentsCount }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <small class="text-white-50">
                            <i class="fas fa-male me-1"></i> {{ $maleStudentsCount }} Males
                        </small>
                        <small class="text-white-50">
                            <i class="fas fa-female me-1"></i> {{ $femaleStudentsCount }} Females
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
            <div class="card stat-card gradient-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white mb-0">My Classes</h6>
                            <h2 class="text-white mt-2 mb-0">{{ $classrooms->count() }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            {{ $classrooms->pluck('name')->take(3)->implode(', ') }}
                            @if($classrooms->count() > 3)
                                <span>...</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
            <div class="card stat-card gradient-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white mb-0">My Subjects</h6>
                            <h2 class="text-white mt-2 mb-0">{{ $subjects->count() }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-book fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            {{ $subjects->pluck('name')->take(3)->implode(', ') }}
                            @if($subjects->count() > 3)
                                <span>...</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
            <div class="card stat-card gradient-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white mb-0">Attendance</h6>
                            <h2 class="text-white mt-2 mb-0">
                                {{ isset($attendanceStats['present']) ? $attendanceStats['present'] : 0 }}
                                <small class="fs-6">present</small>
                            </h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clipboard-check fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <small class="text-white-50">
                            <i class="fas fa-times-circle me-1"></i> {{ isset($attendanceStats['absent']) ? $attendanceStats['absent'] : 0 }} Absent
                        </small>
                        <small class="text-white-50">
                            <i class="fas fa-clock me-1"></i> {{ isset($attendanceStats['late']) ? $attendanceStats['late'] : 0 }} Late
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Weekly Attendance Overview</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Gender Distribution</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Upcoming Birthdays -->
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Marks</h5>
                    <a href="{{ route('teacher.marks.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Mark</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMarks as $mark)
                                <tr>
                                    <td>{{ $mark->student->name }}</td>
                                    <td>{{ $mark->subject->name }}</td>
                                    <td>{{ $mark->classroom->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $mark->mark >= 70 ? 'success' : ($mark->mark >= 50 ? 'warning' : 'danger') }}">
                                            {{ $mark->mark }}
                                        </span>
                                    </td>
                                    <td>{{ $mark->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No recent marks found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Upcoming Birthdays</h5>
                </div>
                <div class="card-body p-0">
                    <div class="birthday-list p-3">
                        @forelse($upcomingBirthdays as $student)
                        <div class="birthday-item d-flex align-items-center mb-3 p-2 border-bottom">
                            <div class="avatar-circle me-3 bg-light">
                                <img src="{{ $student->getImageURL() }}" alt="{{ $student->name }}'s Profile Picture"
                                class="img-fluid rounded-circle shadow-sm" loading="lazy">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $student->name }}</h6>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ $student->next_birthday }} ({{ $student->age }} years)</small>
                                    <span class="badge bg-info">{{ (int) $student->days_until }} days</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-birthday-cake fa-2x text-muted mb-2"></i>
                            <p class="mb-0">No upcoming birthdays</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Performance -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Subject Performance</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <canvas id="subjectPerformanceChart" height="250"></canvas>
                        </div>
                        <div class="col-lg-4">
                            <div class="subject-stats mt-4 mt-lg-0">
                                <h6 class="text-muted mb-3">Average Marks by Subject</h6>
                                @forelse($marksBySubject as $subjectData)
                                <div class="subject-stat-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>{{ $subjectData['subject'] }}</span>
                                        <span class="fw-bold">{{ $subjectData['average'] }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $subjectData['average'] >= 70 ? 'success' : ($subjectData['average'] >= 50 ? 'warning' : 'danger') }}" 
                                            role="progressbar" 
                                            style="width: {{ $subjectData['average'] }}%;" 
                                            aria-valuenow="{{ $subjectData['average'] }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="mb-0">No mark data available</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
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
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('teacher.attendances.create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h6>Take Attendance</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('teacher.marks.create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-success text-white mx-auto mb-3">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                    <h6>Add Marks</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('teacher.attendances.index') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-info text-white mx-auto mb-3">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h6>View Attendance</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('teacher.marks.index') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-warning text-white mx-auto mb-3">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h6>View Marks</h6>
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
        
        .welcome-card {
            background: linear-gradient(to right, #f6f9fc, #f1f5f9);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .avatar-circle {
            width: 50px;
            height: 50px;
            background-color: #4facfe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-initials {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        
        .birthday-list {
            max-height: 350px;
            overflow-y: auto;
        }
        
        .birthday-item {
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .birthday-item:hover {
            background-color: #f8f9fa;
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
                            display: false
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
            
            // Subject Performance Chart
            var subjectCtx = document.getElementById('subjectPerformanceChart').getContext('2d');
            var subjectData = @json($marksBySubject);
            
            var subjectChart = new Chart(subjectCtx, {
                type: 'bar',
                data: {
                    labels: subjectData.map(item => item.subject),
                    datasets: [{
                        label: 'Average Mark',
                        data: subjectData.map(item => item.average),
                        backgroundColor: subjectData.map(item => {
                            if (item.average >= 70) return 'rgba(40, 167, 69, 0.7)';
                            if (item.average >= 50) return 'rgba(255, 193, 7, 0.7)';
                            return 'rgba(220, 53, 69, 0.7)';
                        }),
                        borderColor: subjectData.map(item => {
                            if (item.average >= 70) return '#28a745';
                            if (item.average >= 50) return '#ffc107';
                            return '#dc3545';
                        }),
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
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
