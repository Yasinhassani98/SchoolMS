@extends('layout.base')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center">
            <table class="table table-bordered table-striped">
                <thead class="table ">
                    <tr class="text-center fs-5 ">
                        <td>id</td>
                        <td>name</td>
                        <td>claasroom id</td>
                        <td>phone</td>
                        <td>enrollment date</td>
                        <td>address</td>
                        <td>date of birth</td>
                        <td>parent phone</td>
                        <td>status</td>
                        <td colspan="2"></td>
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
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary"><i
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $students->links('pagination::bootstrap-4') }}
    @endsection
