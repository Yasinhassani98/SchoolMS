@extends('layout.base')
@section('title', 'Marks List')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-3">
                    <h4 class="card-title">Marks List</h4>
                    <h4>{{$student->name}}</h4>
                </div>
                <br>
                <div class="active-member">
                    <div class="table-responsive">
                        <table class="table table-xs text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Subject Name</th>
                                    <th>Classroom</th>
                                    <th>Academic Year</th>
                                    <th>Mark</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marks as $mark)
                                <tr>
                                    <td>{{ $mark->student->name }}</td>
                                    <td>{{ $mark->subject->name }}</td>
                                    <td>{{ $mark->classroom->name }}</td>
                                    <td>{{ $mark->academicYear->name }}</td>
                                    <td>{{ $mark->mark }}</td>
                                    <td>{{ Str::limit($mark->note, 10, '...') ?? '-' }}</td>

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