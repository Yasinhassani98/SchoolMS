@extends('layout.base')
@section('title', 'Attendance List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Attendance List</h4>

                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Classroom</th>
                                        <th>Subject</th>
                                        <th>Academic year</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>{{ $attendance->classroom->name }}</td>
                                            <td>{{ $attendance->subject->name }}</td>
                                            <td>{{ $attendance->academicYear->name }}</td>
                                            <td>{{ $attendance->date->format('Y-m-d') }}
                                            <td>{{ $attendance->status }}</td>
                                            <td>{{ $attendance->notes }}</td>

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
