<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ route('welcome') }}" class="text-decoration-none">
            <span class="brand-title" style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px; background: linear-gradient(45deg, #2E3192, #1BFFFF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-transform: uppercase; letter-spacing: 1px;">
                School MS
            </span>
        </a>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content clearfix">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown mx-2">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="position-relative">
                        <i class="mdi mdi-bell-outline"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge badge-pill gradient-2 position-absolute d-flex justify-content-center align-items-center" style="top: -5px; right: -5px;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                        <div class="dropdown-content-heading d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Notifications</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-primary" style="font-size: 0.8rem;">
                                        Mark all as read
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="dropdown-content-body">
                            <ul class="notification-list">
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    <li class="{{ $notification->read_at ? 'notification-read' : 'notification-unread' }}">
                                        <a href="javascript:void(0)" class="d-flex align-items-center">
                                            @php
                                                $notificationType = $notification->data['type'] ?? 'info';
                                                $iconClass = 'icon-bell';
                                                $bgClass = 'bg-primary-light';
                                                
                                                if ($notificationType == 'success') {
                                                    $iconClass = 'icon-check';
                                                    $bgClass = 'bg-success-lighten-2';
                                                } elseif ($notificationType == 'warning') {
                                                    $iconClass = 'icon-exclamation';
                                                    $bgClass = 'bg-warning-lighten-2';
                                                } elseif ($notificationType == 'danger') {
                                                    $iconClass = 'icon-close';
                                                    $bgClass = 'bg-danger-lighten-2';
                                                } elseif ($notificationType == 'info') {
                                                    $iconClass = 'icon-info';
                                                    $bgClass = 'bg-info-lighten-2';
                                                }
                                            @endphp
                                            <span class="mr-3 avatar-icon {{ $bgClass }}">
                                                <i class="{{ $iconClass }}"></i>
                                            </span>
                                            <div class="notification-content flex-grow-1">
                                                <h6 class="notification-heading font-weight-bold mb-0">
                                                    {{ $notification->data['title'] ?? 'Notification' }}
                                                </h6>
                                                <p class="notification-text mb-0">
                                                    {{ $notification->data['message'] ?? '' }}
                                                </p>
                                            </div>
                                            <div >
                                                <small class="notification-timestamp text-muted">
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </small>
                                                @if(!$notification->read_at)
                                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link p-0 text-primary" style="font-size: 0.7rem;">
                                                            Mark as read
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center py-3">
                                        <span class="text-muted">No notifications</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        @if(auth()->user()->notifications->count() > 5)
                            <div class="text-center py-2 border-top">
                                <a href="{{ route('notifications.index') }}" class="text-primary">View all notifications</a>
                            </div>
                        @endif
                    </div>
                </li>
                
                <li class="icons dropdown d-none d-md-flex">
                    <a href="javascript:void(0)" class="log-user" data-toggle="dropdown">
                        <span>English</span> <i class="fa fa-angle-down f-s-12" aria-hidden="true"></i>
                    </a>
                    <div class="drop-down dropdown-language animated fadeIn  dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="javascript:void()">English</a></li>
                                <li><a href="javascript:void()">Dutch</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        @php
                            $profileImage = 'images/user.png';

                            if (Auth::check()) {
                                $user = Auth::user();

                                if ($user->hasRole('teacher') && $user->teacher) {
                                    $profileImage = $user->teacher->image ? 'storage/' . $user->teacher->image : 'images/user.png';
                                } elseif ($user->hasRole('student') && $user->student) {
                                    $profileImage = $user->student->image ? 'storage/' . $user->student->image : 'images/user.png';
                                } elseif ($user->hasRole('parint') && $user->parint) {
                                    $profileImage = $user->parint->image ? 'storage/' . $user->parint->image : 'images/user.png';
                                }
                            }
                        @endphp
                        <img src="{{ asset($profileImage) }}" height="40" width="40" alt="Profile" class="rounded-circle">

                    </div>

                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{ route('profile.edit') }}"><i class="icon-user"></i>
                                        <span>Profile</span></a>
                                </li>
                                <hr class="my-2">
                                <li>
                                    <form action="{{ route('logout') }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn p-0 border-0 shadow-none bg-transparent">
                                            <i class="icon-power text-danger"></i> <span class="text-danger mx-1">Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>