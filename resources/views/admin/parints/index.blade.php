@extends('layout.base')
@section('title', 'Parents List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center m-3">
                        <h4 class="card-title">Parents List</h4>
                        <form action="{{ route('admin.parents.create') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Parent</button>
                        </form>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Number of children</th>
                                        <th colspan="3">Action</th>
                                    </tr>

                                <tbody>
                                    @forelse($parents as $parent)
                                        <tr>
                                            <td>{{ $parent->name ?? 'null' }}</td>
                                            <td>{{ $parent->phone ?? 'null' }}</td>
                                            <td>{{ $parent->date_of_birth ?? 'null' }}</td>
                                            <td>{{ $parent->children_count ?? 'null' }}</td>
                                            <td>
                                                <a href="{{ route('admin.parents.edit', $parent->id) }}"><i
                                                        class="fa-solid fa-pen-to-square text-warning"></i></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.parents.show', $parent->id) }}"><i
                                                        class="fa-solid fa-eye text-success"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.parents.destroy', $parent->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-0 shadow-none bg-white" type="submit"><i
                                                            class="fa-solid fa-trash text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $parents->links() }}
        </div>
    </div>
@endsection
