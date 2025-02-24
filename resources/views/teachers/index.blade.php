@extends('layout.base')

@section('content')

    <div class="d-flex justify-content-center mt-3 mb-3">
        <form action="{{ route('teachers.create') }}" method="GET">
            <button type="submit" class="btn btn-primary">Add teacher</button>
        </form>
    </div>
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
                        <td colspan="3"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->id ?? 'null'}}</td>
                            <td>{{ $teacher->name ?? 'null'}}</td>
                            <td>{{ $teacher->classroom_id ?? 'null'}}</td>
                            <td>{{ $teacher->phone ?? 'null'}}</td>
                            <td>{{ $teacher->enrollment_date ?? 'null'}}</td>
                            <td>{{ $teacher->address ?? 'null'}}</td>
                            <td>{{ $teacher->date_of_birth ?? 'null'}}</td>
                            <td>{{ $teacher->parent_phone ?? 'null'}}</td>
                            <td>{{ $teacher->status  ?? 'null'}}</td>
                            <td>
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary"><i
                                        class="fa-solid fa-pen-to-square"></i>Edit</a>

                            </td>
                            <td>
                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-primary"><i
                                        class="fa-solid fa-eye"></i>View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $teachers->links('pagination::bootstrap-4') }}
    

@endsection