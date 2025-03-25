@extends('layout.base')
@section('title','Parent Dashboard')
@section('content')
<div class="dashboard-container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body d-flex align-items-center">
                    <div class="welcome-avatar me-4">
                        <div class="avatar-circle">
                            <span class="avatar-initials">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="welcome-text">
                        <h4 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                        <p class="text-muted mb-0">{{ now()->format('l, F d, Y') }}</p>
                    </div>
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
                            <h6 class="card-title text-white mb-0">Total Children</h6>
                            <h2 class="text-white mt-2 mb-0">{{ $children->count() }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <small class="text-white-50">
                            <i class="fas fa-male me-1"></i> {{ $maleCount }} Males
                        </small>
                        <small class="text-white-50">
                            <i class="fas fa-female me-1"></i> {{ $femaleCount }} Females
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
                            <h6 class="card-title text-white mb-0">Upcoming Birthdays</h6>
                            <h2 class="text-white mt-2 mb-0">{{ $upcomingBirthdays->count() }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-birthday-cake fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            Within the next 30 days
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
                            <h6 class="card-title text-white mb-0">Average Marks</h6>
                            <h2 class="text-white mt-2 mb-0">
                                @php
                                    $totalAvg = 0;
                                    $count = count($childrenWithAverages);
                                    foreach($childrenWithAverages as $item) {
                                        $totalAvg += $item['average'];
                                    }
                                    $finalAvg = $count > 0 ? number_format($totalAvg / $count, 1) : 0;
                                @endphp
                                {{ $finalAvg }}
                            </h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-line fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            Average marks for all children
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
                            <h6 class="card-title text-white mb-0">Classrooms</h6>
                            <h2 class="text-white mt-2 mb-0">
                                @php
                                    $classrooms = [];
                                    foreach($children as $child) {
                                        if($child->classroom && !in_array($child->classroom->id, $classrooms)) {
                                            $classrooms[] = $child->classroom->id;
                                        }
                                    }
                                @endphp
                                {{ count($classrooms) }}
                            </h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-school fa-2x text-white-50"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            Number of classrooms enrolled
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Performance and Upcoming Birthdays -->
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Children Performance</h5>
                    <a href="{{ route('parent.children') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Average</th>
                                    <th>Attendance</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($childrenWithAverages as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $item['student']->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item['student']->classroom->name ?? 'Not assigned' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item['average'] >= 70 ? 'success' : ($item['average'] >= 50 ? 'warning' : 'danger') }}">
                                            {{ number_format($item['average'], 1) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $attendanceCount = 0;
                                            $presentCount = 0;
                                            foreach($item['student']->attendances as $attendance) {
                                                $attendanceCount++;
                                                if($attendance->status == 'present') {
                                                    $presentCount++;
                                                }
                                            }
                                            $attendanceRate = $attendanceCount > 0 ? ($presentCount / $attendanceCount) * 100 : 0;
                                        @endphp
                                        <div class="progress" style="height: 8px; width: 80px;">
                                            <div class="progress-bar bg-{{ $attendanceRate >= 75 ? 'success' : ($attendanceRate >= 50 ? 'warning' : 'danger') }}"
                                                role="progressbar"
                                                style="width: {{ $attendanceRate }}%;"
                                                aria-valuenow="{{ $attendanceRate }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('parent.children.show', $item['student']->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No children registered</td>
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
                        @forelse($upcomingBirthdays as $child)
                        <div class="birthday-item d-flex align-items-center mb-3 p-2 border-bottom">
                            <div class="avatar-circle me-3 bg-light">
                                    <img src="{{ $child->getImageURL() }}" alt="{{ $child->name }}" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $child->name }}</h6>
                                <!-- In the birthday display section -->
                                <div class="d-flex justify-content-between">
                                    @php
                                        $birthday = \Carbon\Carbon::parse($child->date_of_birth);
                                        $nextBirthday = $birthday->copy()->year(now()->year);
                                    // Fix for negative days - if birthday has passed this year, use next year's date
                                    if ($nextBirthday->isPast()) {
                                    $nextBirthday->addYear();
                                    }
                                    // Calculate days remaining (always positive)
                                    $daysLeft = now()->diffInDays($nextBirthday, false);
                                    if ($daysLeft < 0) {
                                    $daysLeft = 0; // Failsafe to ensure no negative values
                                    }
                                    $age = $birthday->age;
                                    $nextAge = $age + 1;
                                    @endphp
                                    <small class="text-muted">{{ $nextBirthday->format('Y-m-d') }} ({{ $nextAge }} years)</small>
                                    <span class="badge bg-info">{{ $daysLeft }}</span>
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

    <!-- Children Performance table - update avatar display -->
    <tbody>
        @forelse($childrenWithAverages as $item)
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-2" style="width: 35px; height: 35px;">
                        <img src="{{ $item['student']->getImageURL() }}" alt="{{ $item['student']->name }}" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <span>{{ $item['student']->name }}</span>
                </div>
            </td>
            <td>{{ $item['student']->classroom->name ?? 'Not assigned' }}</td>
            <td>
                <span class="badge bg-{{ $item['average'] >= 70 ? 'success' : ($item['average'] >= 50 ? 'warning' : 'danger') }}">
                    {{ number_format($item['average'], 1) }}
                </span>
            </td>
            <td>
                @php
                    $attendanceCount = 0;
                    $presentCount = 0;
                    foreach($item['student']->attendances as $attendance) {
                        $attendanceCount++;
                        if($attendance->status == 'present') {
                            $presentCount++;
                        }
                    }
                    $attendanceRate = $attendanceCount > 0 ? ($presentCount / $attendanceCount) * 100 : 0;
                @endphp
                <div class="progress" style="height: 8px; width: 80px;">
                    <div class="progress-bar bg-{{ $attendanceRate >= 75 ? 'success' : ($attendanceRate >= 50 ? 'warning' : 'danger') }}"
                        role="progressbar"
                        style="width: {{ $attendanceRate }}%;"
                        aria-valuenow="{{ $attendanceRate }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </td>
            <td>
                <a href="{{ route('parent.children.show', $item['student']->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-3">No children registered</td>
        </tr>
        @endforelse
    </tbody>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('parent.children') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h6>Children List</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-success text-white mx-auto mb-3">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h6>Attendance Reports</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="quick-action-card bg-light p-3 text-center rounded h-100">
                                    <div class="icon-circle bg-info text-white mx-auto mb-3">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h6>Grade Reports</h6>
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

    .gradient-1 {
        background: linear-gradient(to right, #4facfe, #00f2fe);
    }

    .gradient-2 {
        background: linear-gradient(to right, #ff6a00, #ee0979);
    }

    .gradient-3 {
        background: linear-gradient(to right, #11998e, #38ef7d);
    }

    .gradient-4 {
        background: linear-gradient(to right, #6a11cb, #2575fc);
    }
</style>
@endpush

@push('scripts')
<script>
    // You can add any custom JavaScript here if needed
</script>
@endpush
