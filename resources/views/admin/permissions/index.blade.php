@extends('layout.base')
@section('title', 'Permissions Management')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-3">
                    <h4 class="card-title">Permissions Management</h4>
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Permission
                    </a>
                </div>
                
                <div class="active-member">
                    <div class="table-responsive">
                        <table class="table table-xs text-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Created At</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $permission->name }}</span>
                                    </td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>{{ $permission->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn p-0 border-0 shadow-none bg-white" type="submit" onclick="return confirm('Are you sure? This may affect roles using this permission.')">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No permissions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            {{ $permissions->links() }}
    </div>
</div>
@endsection