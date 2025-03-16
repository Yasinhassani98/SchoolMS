@extends('layout.base')
@section('title', 'Attendance List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Attendance List</h4>
                        <form action="{{ route('admin.attendances.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Attendance</button>
                        </form>
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
                                        <th colspan="2">Actions</th>
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
                                            </td>
                                            <td>
                                                @if ($attendance->status == 'present')
                                                    <span class="badge badge-success">Present</span>
                                                @elseif($attendance->status == 'absent')
                                                    <span class="badge badge-danger">Absent</span>
                                                @elseif($attendance->status == 'late')
                                                    <span class="badge badge-warning">Late</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $attendance->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($attendance->note, 10, '...') ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.attendances.edit', $attendance->id) }}"><i
                                                        class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.attendances.destroy', $attendance->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i
                                                            class="fa-solid fa-trash text-danger"></i></button>
                                                </form>
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
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
