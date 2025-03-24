@extends('layout.base')
@section('title', 'Subject List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Subjects List</h4>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Level Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->name ?? '' }}</td>
                                            <td>{{ $subject->level->name ?? '' }}</td>
                                            <td>{{ $subject->description ?? '' }}</td>
                                            <td>
                                                <a href="{{ route('student.subjects.show', $subject->id) }}"
                                                    class="btn btn-info btn-sm rounded-pill shadow-sm"><i
                                                        class="fas fa-eye me-1"></i>Show</a>
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
        </div>
    </div>
@endsection
