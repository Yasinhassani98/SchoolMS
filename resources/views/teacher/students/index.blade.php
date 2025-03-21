@extends('layout.base')
@section('title', 'students List')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-3">
                    <h4 class="card-title">students List</h4>
                </div>
                <div class="active-member">
                    <div class="table-responsive">
                        <table class="table table-xs text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>phone</th>
                                    <th>Enrollment Date</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>status</th>
                                    <th colspan="3">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->name ?? 'null'}}</td>
                                    <td>{{ $student->gender ?? 'null'}}</td>
                                    <td>{{ $student->phone ?? 'null'}}</td>
                                    <td>{{ $student->enrollment_date ?? 'null'}}</td>
                                    <td>{{ $student->date_of_birth ?? 'null'}}</td>
                                    <td>{{ $student->address ?? 'null'}}</td>
                                    <td>{{ $student->status ?? 'null'}}</td>
                                    <td>
                                        <a href="{{ route('teacher.students.show', $student->id) }}"
                                            ><i class="fa-solid fa-eye text-success"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">No data found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{ $students->links() }}
    </div>
</div>
@endsection