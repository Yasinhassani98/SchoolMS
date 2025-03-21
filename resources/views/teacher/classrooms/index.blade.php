@extends('layout.base')
@section('title', 'Classrooms List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">classrooms List</h4>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Classroom Name</th>
                                        <th>Level Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classrooms as $classroom)
                                        <tr>
                                            <td>{{ $classroom->name }}</td>
                                            <td>{{ $classroom->level->name }}</td>
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
            {{ $classrooms->links() }}
        </div>
    </div>
@endsection
