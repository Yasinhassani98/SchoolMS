<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add user ID meta tag for notifications -->
    @auth
        <meta name="user-id" content="{{ Auth::id() }}">
    @endauth

    <title>@yield('title')</title>


    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Pignose Calender -->
    <link href="{{ asset('plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">

    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">

    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Add Toast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom notification styling -->
    <style>
        #notification-container .alert {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
            pointer-events: auto;
            opacity: 0;
            transform: translateX(30px);
            animation: slide-in 0.3s ease forwards;
        }
        
        @keyframes slide-in {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        #notification-container .alert.fade-out {
            opacity: 1;
            animation: slide-out 0.3s ease forwards;
        }
        
        @keyframes slide-out {
            to {
                opacity: 0;
                transform: translateX(30px);
            }
        }
        
        #notification-container .notification-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        #notification-container .notification-title {
            font-weight: 600;
            font-size: 16px;
        }
        
        #notification-container .notification-message {
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
    
    @stack('styles')

    <!-- Vite Assets -->
    @vite(['resources/js/app.js'])
</head>

<body>

    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        @include('layout.nav-header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layout.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->

        <div class="content-body">
            <div class="container-fluid mt-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        @include('layout.footer')
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!-- Required vendors -->
    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>

    <!-- Bootstrap Bundle with Popper (moved up for dependency) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- تضمين JS لـ jQuery (إذا لم يكن مضمناً) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- تضمين JS لـ Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Add toast container div with improved styling -->
    <div id="notification-container" style="
        position: fixed; 
        top: 20px; 
        right: 20px; 
        z-index: 1050;
        max-width: 350px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    ">
        <!-- Notifications will be inserted here dynamically -->
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userId = document.querySelector('meta[name="user-id"]').content;
            if (!userId) return;
            window.Echo.private(`App.Models.User.${userId}`)
                .notification((notification) => {
                    // Determine alert type based on notification.type
                    let alertType = 'success';
                    let iconClass = 'fa-check-circle';
                    
                    switch(notification.notification_type) {
                        case 'success':
                            alertType = 'success';
                            iconClass = 'fa-check-circle';
                            break;
                        case 'warning':
                            alertType = 'warning';
                            iconClass = 'fa-exclamation-triangle';
                            break;
                        case 'danger':
                        case 'error':
                            alertType = 'danger';
                            iconClass = 'fa-exclamation-circle';
                            break;
                        case 'info':
                            alertType = 'info';
                            iconClass = 'fa-info-circle';
                            break;
                        default:
                            alertType = 'primary';
                            iconClass = 'fa-bell';
                    }
                    
                    const container = document.getElementById('notification-container');
                    const alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', `alert-${alertType}`, 'alert-dismissible', 'fade', 'show');
                    alertDiv.innerHTML = `
                        <div class="d-flex align-items-center p-3">
                            <div class="notification-icon me-3">
                                <i class="fas ${iconClass} fa-lg" style="color: var(--bs-alert-color)"></i>
                            </div>
                            <div class="notification-content flex-grow-1">
                                <h6 class="notification-title mb-1">${notification.title}</h6>
                                <p class="notification-message mb-0">${notification.message}</p>
                            </div>
                            <button type="button" class="btn-close ms-2" 
                                    data-bs-dismiss="alert" 
                                    aria-label="Close"
                                    style="position: absolute; top: 10px; right: 10px;">
                            </button>
                        </div>
                    `;
                    
                    container.appendChild(alertDiv);
                    setTimeout(() => alertDiv.remove(), 5000);
                });
        });
    </script>

    @stack('scripts')

</body>

</html>
