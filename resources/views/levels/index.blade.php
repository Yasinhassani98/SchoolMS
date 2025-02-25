@extends('layout.base')
@section('title', 'Level List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Level List</h4>
                        <form action="{{ route('levels.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Level</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($levels as $level)
                                        <tr>
                                            <td>{{ $level->name }}</td>
                                            <td>{{ $level->level }}</td>
                                            <td>
                                                <a href="{{ route('levels.edit', $level->id) }}"
                                                    ><i class="fa-solid fa-pen-to-square text-warning"></i></a>
                                                <form action="{{ route('levels.destroy', $level->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i class="fa-solid fa-trash text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $levels->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection