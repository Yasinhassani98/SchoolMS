@extends('layout.base')
@section('title', 'teachers List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Students List</h4>
                        <form action="{{ route('teachers.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add teacher</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs mb-0">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>name</th>
                                        <th>claasroom id</th>
                                        <th>phone</th>
                                        <th>enrollment date</th>
                                        <th>address</th>
                                        <th>DOB</th>
                                        <th>parent contact</th>
                                        <th>status</th>
                                        <th colspan="3">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->classroom_id }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->enrollment_date }}</td>
                                            <td>{{ $student->address }}</td>
                                            <td>{{ $student->date_of_birth }}</td>
                                            <td>{{ $student->parent_phone }}</td>
                                            <td>{{ $student->status }}</td>
                                            <td>
                                                <a href="{{ route('students.edit', $student->id) }}"
                                                    class="btn btn-primary"><i
                                                        class="fa-solid fa-pen-to-square"></i>Edit</a>

                                            </td>
                                            <td>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('students.show', $student->id) }}"
                                                    class="btn btn-primary"><i class="fa-solid fa-eye"></i>View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $students->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
