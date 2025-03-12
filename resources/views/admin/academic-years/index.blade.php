@extends('layout.base')
@section('title', 'Academic Years')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-3">
                    <h4 class="card-title">Academic Years</h4>
                    <a href="{{ route('admin.academic-years.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Academic Year
                    </a>
                </div>
                
                <div class="active-member">
                    <div class="table-responsive">
                        <table class="table table-xs text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academicYears as $academicYear)
                                <tr>
                                    <td>{{ $academicYear->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d M, Y') }}</td>
                                    <td>
                                        @if($academicYear->is_current)
                                            <span class="badge bg-success">Current</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($academicYear->description, 30) }}</td>
                                    <td>
                                        @if(!$academicYear->is_current)
                                            <form action="{{ route('admin.academic-years.set-current', $academicYear->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn p-0 border-0 shadow-none bg-white" type="submit" title="Set as Current">
                                                    <i class="fa fa-check-circle text-info"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.academic-years.edit', $academicYear->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.academic-years.show', $academicYear->id) }}">
                                            <i class="fa-solid fa-eye text-success"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.academic-years.destroy', $academicYear->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn p-0 border-0 shadow-none bg-white" type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this academic year?')">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No academic years found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{ $academicYears->links() }}
    </div>
</div>
@endsection