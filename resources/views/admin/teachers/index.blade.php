@extends('layout.base')
@section('title', 'teachers List')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-3">
                    <h4 class="card-title">teachers List</h4>
                    <form action="{{ route('admin.teachers.create') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add teacher</button>
                    </form>
                </div>
                <div class="active-member">
                    <div class="table-responsive">
                        <table class="table table-xs text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>phone</th>
                                    <th>Hiring Date</th>
                                    <th>Date of Birth</th>
                                    <th>Specialization</th>
                                    <th>status</th>
                                    <th colspan="3">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->gender }}</td>
                                    <td>{{ $teacher->user->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->hiring_date }}</td>
                                    <td>{{ $teacher->date_of_birth }}</td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>{{ $teacher->status }}</td>
                                    <td>
                                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                            ><i class="fa-solid fa-pen-to-square text-warning"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                                            ><i class="fa-solid fa-eye text-success"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i class="fa-solid fa-trash text-danger"></i></button>
                                        </form>
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
                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection