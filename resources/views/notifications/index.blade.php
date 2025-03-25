@extends('layout.base')
@section('title', 'Notifications')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Notifications</h4>
                    <span>View and manage all your notifications</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifications</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Notifications</h4>
                        <div>
                            @can('manage-notifications')
                                <form class="d-inline" action="{{ route('notifications.create') }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Add New Notification
                                    </button>
                                </form>
                            @endcan

                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check-double" title="Mark All As Read"></i>
                                    </button>
                                </form>
                            @endif

                            <div class="dropdown ml-2 d-inline">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filter
                                    @if(request('filter') || request('type'))
                                        <span class="badge bg-light text-dark ms-1">Active</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="filterDropdown" style="min-width: 200px;">
                                    <li><h6 class="dropdown-header">Status</h6></li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ !request('filter') ? 'active' : '' }}"
                                            href="{{ route('notifications.index') }}">
                                            All
                                            @if(!request('filter'))
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('filter') == 'unread' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['filter' => 'unread'], request('type') ? ['type' => request('type')] : [])) }}">
                                            Unread
                                            @if(request('filter') == 'unread')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('filter') == 'read' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['filter' => 'read'], request('type') ? ['type' => request('type')] : [])) }}">
                                            Read
                                            @if(request('filter') == 'read')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Type</h6></li>
                                    
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ !request('type') ? 'active' : '' }}"
                                            href="{{ route('notifications.index', request('filter') ? ['filter' => request('filter')] : []) }}">
                                            All Types
                                            @if(!request('type'))
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('type') == 'info' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['type' => 'info'], request('filter') ? ['filter' => request('filter')] : [])) }}">
                                            <span><i class="fas fa-info-circle text-info me-2"></i> Information</span>
                                            @if(request('type') == 'info')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('type') == 'success' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['type' => 'success'], request('filter') ? ['filter' => request('filter')] : [])) }}">
                                            <span><i class="fas fa-check-circle text-success me-2"></i> Success</span>
                                            @if(request('type') == 'success')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('type') == 'warning' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['type' => 'warning'], request('filter') ? ['filter' => request('filter')] : [])) }}">
                                            <span><i class="fas fa-exclamation-triangle text-warning me-2"></i> Warning</span>
                                            @if(request('type') == 'warning')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('type') == 'danger' ? 'active' : '' }}"
                                            href="{{ route('notifications.index', array_merge(['type' => 'danger'], request('filter') ? ['filter' => request('filter')] : [])) }}">
                                            <span><i class="fas fa-exclamation-circle text-danger me-2"></i> Error</span>
                                            @if(request('type') == 'danger')
                                                <i class="fas fa-check text-primary"></i>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($notifications->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-bell text-muted" style="font-size: 4rem;"></i>
                                <h4 class="mt-3">No notifications found</h4>
                                <p class="text-muted">You don't have any notifications at the moment.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;"></th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr class="{{ $notification->read_at ? '' : 'table-active' }}">
                                                <td>
                                                    @php
                                                        $notificationType = $notification->data['type'] ?? 'info';
                                                        $iconClass = 'fas fa-exclamation-circle text-danger me-2';
                                                        

                                                        if ($notificationType == 'success') {
                                                            $iconClass = 'fas fa-check-circle text-success me-2';
                                                            
                                                        } elseif ($notificationType == 'warning') {
                                                            $iconClass = 'fas fa-exclamation-triangle text-warning me-2';
                                                            
                                                        } elseif ($notificationType == 'danger') {
                                                            $iconClass = 'fas fa-exclamation-circle text-danger me-2';
                                                            
                                                        }
                                                    @endphp
                                                    <span>
                                                        <i class="{{ $iconClass }}"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                                                    @if (!$notification->read_at)
                                                        <span class="badge badge-primary ml-2">New</span>
                                                    @endif
                                                </td>
                                                <td>{{ $notification->data['message'] ?? '' }}</td>
                                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if (!$notification->read_at)
                                                            <form
                                                                action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                                method="POST" class="mr-1">
                                                                @csrf
                                                                <button type="submit" class="btn p-0 border-0 shadow-none">
                                                                    <i class="fa-solid fa-eye text-success"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('notifications.markAsUnread', $notification->id) }}"
                                                                method="POST" class="mr-1">
                                                                @csrf
                                                                <button type="submit" class="btn p-0 border-0 shadow-none">
                                                                    <i class="fa-solid fa-eye-slash text-success"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('notifications.destroy', $notification->id) }}"
                                                            method="POST" class="ml-1"
                                                            onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn p-0 border-0 shadow-none ">
                                                                <i class="fa-solid fa-trash text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
