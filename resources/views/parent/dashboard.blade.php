@extends('layout.base')
@section('title', 'Children List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Children List</h4>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Level Name</th>
                                        <th>Classroom Name</th>
                                        <th>Gender</th>
                                        <th>Enrollment Date</th>
                                        <th>status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($children as $child)
                                        <tr>
                                            <td>{{ $child->name ?? 'null' }}</td>
                                            <td>{{ $child->classroom->level->name ?? 'null' }}</td>
                                            <td>{{ $child->classroom->name ?? 'null' }}</td>
                                            <td>{{ $child->gender ?? 'null' }}</td>
                                            <td>{{ $child->enrollment_date ?? 'null' }}</td>
                                            <td>{{ $child->status ?? 'null' }}</td>
                                            <td>
                                                <a href="{{ route('parent.children.show', $child->id) }}"><i
                                                        class="fa-solid fa-eye text-success"></i></a>
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
        </div>
    </div>
@endsection
