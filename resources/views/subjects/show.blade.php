@extends('layout.base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title
                        ">Subject Details</h3>
                        <a href="{{ route('subjects.index') }}" class="btn btn-primary float-left">Back</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Level name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $subject->name ?? '' }}</td>
                                    <td>{{ $subject->level->name ?? '' }}</td>
                                    <td>{{ $subject->description ?? '' }}</td>
                                    <td>{{ $subject->type ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
