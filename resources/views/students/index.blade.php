@extends('layout.base')

@section('content')
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs mb-0">
                                <thead>
                                    <tr>
                                        <td>id</td>
                                        <td>name</td>
                                        <td>claasroom id</td>
                                        <td>phone</td>
                                        <td>enrollment date</td>
                                        <td>address</td>
                                        <td>DOB</td>
                                        <td>parent contact</td>
                                        <td>status</td>
                                        <td colspan="2">action</td>
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
