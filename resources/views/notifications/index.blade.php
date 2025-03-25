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
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            @endcan
                            
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                </form>
                            @endif

                            <div class="dropdown ml-2 d-inline">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                    id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item {{ request('filter') == '' ? 'active' : '' }}"
                                        href="{{ route('notifications.index') }}">All</a>
                                    <a class="dropdown-item {{ request('filter') == 'unread' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['filter' => 'unread']) }}">Unread</a>
                                    <a class="dropdown-item {{ request('filter') == 'read' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['filter' => 'read']) }}">Read</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item {{ request('type') == 'info' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['type' => 'info']) }}">Information</a>
                                    <a class="dropdown-item {{ request('type') == 'success' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['type' => 'success']) }}">Success</a>
                                    <a class="dropdown-item {{ request('type') == 'warning' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['type' => 'warning']) }}">Warning</a>
                                    <a class="dropdown-item {{ request('type') == 'danger' ? 'active' : '' }}"
                                        href="{{ route('notifications.index', ['type' => 'danger']) }}">Error</a>
                                </div>
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
                                                        $iconClass = 'fa-info-circle';
                                                        $bgClass = 'bg-info';

                                                        if ($notificationType == 'success') {
                                                            $iconClass = 'fa-check-circle';
                                                            $bgClass = 'bg-success';
                                                        } elseif ($notificationType == 'warning') {
                                                            $iconClass = 'fa-exclamation-triangle';
                                                            $bgClass = 'bg-warning';
                                                        } elseif ($notificationType == 'danger') {
                                                            $iconClass = 'fa-exclamation-circle';
                                                            $bgClass = 'bg-danger';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $bgClass }} text-white p-2">
                                                        <i class="fas {{ $iconClass }}"></i>
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
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('notifications.markAsUnread', $notification->id) }}"
                                                                method="POST" class="mr-1">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-undo"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('notifications.destroy', $notification->id) }}"
                                                            method="POST" class="ml-1"
                                                            onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $notifications->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert-dismissible').alert('close');
            }, 5000);
        });
    </script>
@endsection
