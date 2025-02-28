@extends('layout.base')
@section('title', 'Marks List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Marks List</h4>
                        <form action="{{ route('marks.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Mark</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Subject Name</th>
                                        <th>Mark</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($marks as $mark)
                                        <tr>
                                            <td>{{ $mark->student->name }}</td>
                                            <td>{{ $mark->subject->name }}</td>
                                            <td>{{ $mark->mark }}</td>
                                            <td>
                                                <a href="{{ route('marks.edit', $mark->id) }}"><i
                                                        class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('marks.destroy', $mark->id) }}" method="POST"
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
            {{-- {{ $marks->links() }} --}}
        </div>
    </div>
@endsection
