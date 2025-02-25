@extends('layout.base')
@section('title', 'Subject List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Subjects List</h4>
                        <form action="{{ route('subjects.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Subject</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Level Name</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->level->name }}</td>
                                            <td>{{ $subject->description }}</td>
                                            <td>{{ $subject->type }}</td>
                                            <td>
                                                <a href="{{ route('subjects.edit', $subject->id) }}"><i
                                                        class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('subjects.show', $subject->id) }}"><i
                                                        class="fa-solid fa-eye text-success"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i
                                                            class="fa-solid fa-trash text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $subjects->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
