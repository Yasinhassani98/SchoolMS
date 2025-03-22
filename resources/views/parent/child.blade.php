@extends('layout.base')
@section('title', 'Student Details')
@section('content')

    <div class="card mb-4 mt-4 shadow-lg">
        <div class="card-header bg-gradient-primary text-white text-center py-3">
            <h4 class="mb-0">{{ $student->name }}</h4>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <img src="{{ $student->getImageURL() }}" alt="{{ $student->name }}'s Profile Picture"
                        class="img-fluid rounded-circle shadow" style="width: 180px; height: 180px; object-fit: cover;"
                        loading="lazy">
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table table-hover table-bordered">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Mark</th>
                            <th scope="col"><i class="fas fa-check-circle"></i> Present</th>
                            <th scope="col"><i class="fas fa-clock"></i> Late</th>
                            <th scope="col"><i class="fas fa-times-circle"></i> Absent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjectData as $index => $subject)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold text-start">{{ $subject['subject'] ?? 'N/A' }}</td>
                                <td>{{ $subject['teacher'] ?? 'N/A' }}</td>
                                <td>{{ $subject['mark'] ?? 'N/A' }}</td>
                                <td class="text-success fw-bold">{{ $subject['present_count'] ?? '0' }}</td>
                                <td class="text-warning fw-bold">{{ $subject['late_count'] ?? '0' }}</td>
                                <td class="text-danger fw-bold">{{ $subject['absent_count'] ?? '0' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-secondary">Overall Average Mark</h5>
                            <h1
                                class="display-3 fw-bold {{ $average >= 70 ? 'text-success' : ($average >= 50 ? 'text-warning' : 'text-danger') }}">
                                {{ number_format($average, 2) }}%
                            </h1>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar {{ $average >= 70 ? 'bg-success' : ($average >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                    role="progressbar" style="width: {{ $average }}%;"
                                    aria-valuenow="{{ $average }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($average, 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
