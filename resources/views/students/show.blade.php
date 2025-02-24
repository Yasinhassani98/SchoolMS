@extends('layout.base')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="m-0">Student Details</h3>
            <a href="{{ route('students.index') }}" class="btn btn-light">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Student ID:</th>
                            <td>{{ $student->id }}</td>
                        </tr>
                        <tr>
                            <th>Name :</th>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $student->email }}</td>
                        </tr>
                        <tr>
                            <th>Class :</th>
                            <td>{{ $student->classroom->name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth:</th>
                            <td>{{ $student->date_of_birth ??'' }}</td>
                        </tr>
                        <tr>
                            <th>Parent phone:</th>
                            <td>{{ $student->parent_phone??"" }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $student->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $student->address }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection