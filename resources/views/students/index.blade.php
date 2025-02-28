@extends('layout.base')
@section('title', 'Students List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Students List</h4>
                        <form action="{{ route('students.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Claasroom Name</th>
                                        <th>Phone</th>
                                        <th>Enrollment Date</th>
                                        <th>Address</th>
                                        <th>DOB</th>
                                        <th>Parent Contact</th>
                                        <th>Status</th>
                                        <th colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->classroom->name }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->enrollment_date }}</td>
                                            <td>{{ $student->address }}</td>
                                            <td>{{ $student->date_of_birth }}</td>
                                            <td>{{ $student->parent_phone }}</td>
                                            <td>{{ $student->status }}</td>
                                            <td>
                                                <a href="{{ route('students.edit', $student->id) }}"
                                                    ><i class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('students.show', $student->id) }}"
                                                    ><i class="fa-solid fa-eye text-success"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i class="fa-solid fa-trash text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
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
