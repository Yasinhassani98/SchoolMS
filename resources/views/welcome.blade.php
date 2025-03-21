<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="School Management System - Streamline your educational institution's operations">

    <title>School Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <style>
        :root {
            --primary: #6d28d9;
            --primary-light: #8b5cf6;
            --primary-dark: #5b21b6;
            --secondary: #f8f9fa;
            --text-dark: #212529;
            --text-light: #6c757d;
        }

        body {
            font-family: 'Figtree', sans-serif;
            color: var(--text-dark);
        }

        .text-primary-custom {
            color: var(--primary) !important;
        }

        .bg-primary-custom {
            background-color: var(--primary) !important;
        }

        .btn-primary-custom {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-outline-primary-custom {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary);
            color: white;
        }

        .hero-section {
            padding-top: 7rem;
            padding-bottom: 5rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            position: relative;
            overflow: hidden;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background-color: var(--secondary);
            color: var(--primary);
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 1rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .gradient-text {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 gradient-text" href="/">SchoolMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#contact">Contact</a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link px-3 text-primary-custom">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary-custom rounded-pill px-4">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="btn btn-primary-custom rounded-pill px-4">
                                Login
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item ms-2">
                                <a href="{{ route('register') }}" class="btn btn-outline-primary-custom rounded-pill px-4">
                                    Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Streamline Your School Management</h1>
                    <p class="lead text-muted mb-5">
                        A comprehensive solution for educational institutions to manage students, teachers, classes, and more.
                    </p>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3 me-3">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3 me-3">
                            Get Started
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary-custom btn-lg rounded-pill px-5 py-3">
                                Create Account
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="col-lg-6">
                    <img src="https://cdn.pixabay.com/photo/2018/01/17/07/06/laptop-3087585_1280.jpg" alt="School Management System" 
                         class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 py-md-7" id="features">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Student Management</h3>
                        <p class="text-muted mb-0">Easily manage student information, attendance, and academic performance in one place.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Curriculum Planning</h3>
                        <p class="text-muted mb-0">Plan and organize your curriculum, subjects, and class schedules efficiently.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Fee Management</h3>
                        <p class="text-muted mb-0">Streamline fee collection, generate invoices, and track payments with ease.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Examination System</h3>
                        <p class="text-muted mb-0">Create exams, manage grades, and generate comprehensive performance reports.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Attendance Tracking</h3>
                        <p class="text-muted mb-0">Track student and staff attendance with automated reports and notifications.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Communication Tools</h3>
                        <p class="text-muted mb-0">Facilitate communication between teachers, students, and parents through integrated messaging.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 py-md-7 bg-light" id="about">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">About Our System</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <p class="lead">
                        Our School Management System is designed to simplify administrative tasks, enhance communication, and improve 
                        educational outcomes. With a user-friendly interface and comprehensive features, we help educational institutions 
                        of all sizes operate more efficiently.
                    </p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="display-4 fw-bold text-primary-custom mb-3">500+</div>
                        <p class="mb-0">Schools Using Our System</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="display-4 fw-bold text-primary-custom mb-3">50,000+</div>
                        <p class="mb-0">Students Managed</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-sm p-4">
                        <div class="display-4 fw-bold text-primary-custom mb-3">98%</div>
                        <p class="mb-0">Customer Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-5 py-md-7">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4">Why Choose Our School Management System?</h2>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-3">
                            <div class="text-primary-custom me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span class="fs-5">User-friendly interface for all stakeholders</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="text-primary-custom me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span class="fs-5">Comprehensive reporting and analytics</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="text-primary-custom me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span class="fs-5">Secure data management and privacy controls</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="text-primary-custom me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span class="fs-5">Regular updates and dedicated support</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="https://cdn.pixabay.com/photo/2018/03/27/21/43/startup-3267505_1280.jpg" alt="School Management Dashboard" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 py-md-7 bg-light" id="contact">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-5">
                            <p class="text-center mb-4">
                                Have questions about our School Management System? Get in touch with our team for more information or to schedule a demo.
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-medium">Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-3" id="name" placeholder="Your name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control form-control-lg rounded-3" id="email" placeholder="Your email">
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-medium">Message</label>
                                    <textarea class="form-control form-control-lg rounded-3" id="message" rows="5" placeholder="Your message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill px-5">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <h3 class="gradient-text fw-bold mb-3 fs-4">SchoolMS</h3>
                        <p class="text-white-50">
                            A comprehensive school management solution designed to streamline administrative tasks and enhance educational outcomes.
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none hover-text-white">Features</a></li>
                        <li class="mb-2"><a href="#about" class="text-white-50 text-decoration-none hover-text-white">About</a></li>
                        <li class="mb-2"><a href="#contact" class="text-white-50 text-decoration-none hover-text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3">Resources</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white">Documentation</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white">Support</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3">Contact</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">Email: info@schoolms.com</li>
                        <li class="mb-2">Phone: +1 (123) 456-7890</li>
                        <li class="mb-2">Address: 123 Education St, Learning City</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-white-50">
                &copy; {{ date('Y') }} School Management System. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
                    