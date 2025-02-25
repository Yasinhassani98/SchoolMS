@extends('layout.base')

@section('title', 'Subject List')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">المواد الدراسية</h3>
                        <a href="{{ route('subjects.create') }}" class="btn btn-primary float-left">
                            إضافة مادة جديدة
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-xs mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject Name</th>
                                    <th>Level Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th colspan="3">actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->id ?? '' }}</td>
                                        <td>{{ $subject->name ?? '' }}</td>
                                        <td>{{ $subject->level->name ?? '' }}</td>
                                        <td>{{ $subject->description ?? '' }}</td>
                                        <td>{{ $subject->type ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-primary"><i
                                                    class="fa-solid fa-pen-to-square"></i>Edit</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('subjects.show', $subject->id) }}" class="btn btn-primary"><i
                                                    class="fa-solid fa-eye"></i>View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد مواد مسجلة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $subjects->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
