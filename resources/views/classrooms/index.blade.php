@extends('layout.base')
@section('title', 'Classrooms List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">classrooms List</h4>
                        <form action="{{ route('classrooms.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add classroom</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Classroom Name</th>
                                        <th>Level Name</th>
                                        {{-- <th>classroom</th> --}}
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classrooms as $classroom)
                                        <tr>
                                            <td>{{ $classroom->name }}</td>
                                            <td>{{ $classroom->level->name }}</td>
                                            {{-- <td>{{ $classroom->classroom }}</td> --}}
                                            <td>
                                                <a href="{{ route('classrooms.edit', $classroom->id) }}"><i
                                                        class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST"
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
            {{ $classrooms->links() }}
        </div>
    </div>
@endsection
