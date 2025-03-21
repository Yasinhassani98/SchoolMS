<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - School Management System</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6d28d9;
            --primary-light: #8b5cf6;
            --primary-dark: #5b21b6;
            --secondary: #f8f9fa;
            --text-dark: #212529;
            --text-light: #6c757d;
        }
        
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }
        .login-title {
            color: #2d3748;
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: #667eea;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #764ba2;
            transform: translateY(-1px);
        }
        .brand-logo {
            width: 120px;
            margin-bottom: 2rem;
        }
        .gradient-text {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>

<body>
    <div class="login-container d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="login-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <a class="navbar-brand fw-bold fs-4 gradient-text" href="/">SchoolMS</a>
                            <h2 class="login-title">Welcome Back</h2>
                            <p class="text-muted">Please sign in to continue</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-login text-white w-100 mb-3">
                                Sign In <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>

                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}" class="text-muted">
                                        Forgot your password?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
