<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | No Food Waste</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
    
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <style>
        /* Page-specific styles */
        body {
            background: url('{{ asset('assets/images/food-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(44, 107, 47, 0.9), rgba(33, 84, 36, 0.8));
            z-index: -1;
        }
        
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-md);
        }
        
        .login-container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
        }
        
        .login-sidebar {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: var(--spacing-xl);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 40%;
            position: relative;
            overflow: hidden;
        }
        
        .login-sidebar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('{{ asset('assets/images/pattern.svg') }}') repeat;
            opacity: 0.1;
            animation: rotate 120s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .login-sidebar-content {
            position: relative;
            z-index: 1;
        }
        
        .login-logo {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-xl);
        }
        
        .login-logo-circle {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: var(--spacing-sm);
            color: var(--primary);
            font-size: 1.5rem;
            box-shadow: var(--shadow-md);
        }
        
        .login-logo-text {
            font-size: var(--font-size-xl);
            font-weight: 700;
        }
        
        .login-slogan {
            margin-bottom: var(--spacing-xl);
        }
        
        .login-slogan h1 {
            font-size: var(--font-size-3xl);
            font-weight: 800;
            margin-bottom: var(--spacing-md);
            line-height: 1.2;
        }
        
        .login-slogan p {
            font-size: var(--font-size-base);
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .login-features {
            margin-bottom: var(--spacing-xl);
        }
        
        .login-feature {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }
        
        .login-feature-icon {
            width: 36px;
            height: 36px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: var(--spacing-md);
            color: white;
        }
        
        .login-sidebar-footer {
            font-size: var(--font-size-sm);
            opacity: 0.8;
        }
        
        .login-form-container {
            padding: var(--spacing-xl);
            width: 60%;
            position: relative;
            overflow: hidden;
        }
        
        .login-welcome {
            margin-bottom: var(--spacing-xl);
            text-align: center;
        }
        
        .login-welcome h2 {
            font-size: var(--font-size-2xl);
            color: var(--neutral-900);
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }
        
        .login-welcome p {
            color: var(--neutral-600);
            font-size: var(--font-size-base);
        }
        
        .form-floating {
            margin-bottom: var(--spacing-lg);
            position: relative;
        }
        
        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            color: var(--neutral-600);
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity .1s ease-in-out,transform .1s ease-in-out;
        }
        
        .form-floating > .form-control {
            padding: 1rem 0.75rem;
            height: calc(3.5rem + 2px);
            line-height: 1.25;
        }
        
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: .65;
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
            background-color: white;
            height: auto;
            padding: 0 0.5rem;
            margin-left: 0.5rem;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--primary);
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(44, 107, 47, 0.25);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
            color: var(--neutral-600);
        }
        
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-right: 0.5em;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            margin-bottom: 0;
            font-size: var(--font-size-sm);
            color: var(--neutral-700);
            cursor: pointer;
        }
        
        .forgot-password {
            font-size: var(--font-size-sm);
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-btn {
            display: block;
            width: 100%;
            padding: 0.8rem;
            font-size: var(--font-size-base);
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: var(--radius-md);
            background-color: var(--primary);
            color: white;
            cursor: pointer;
            transition: var(--transition-normal);
            margin-bottom: var(--spacing-lg);
        }
        
        .login-btn:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .login-btn-icon {
            margin-right: var(--spacing-sm);
        }
        
        .auth-separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: var(--spacing-lg) 0;
        }
        
        .auth-separator::before,
        .auth-separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--neutral-300);
        }
        
        .auth-separator-text {
            padding: 0 var(--spacing-md);
            color: var(--neutral-600);
            font-size: var(--font-size-sm);
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--neutral-100);
            color: var(--neutral-700);
            font-size: var(--font-size-lg);
            transition: var(--transition-normal);
            border: 1px solid var(--neutral-300);
            text-decoration: none;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .social-btn.facebook:hover {
            background-color: #3b5998;
            color: white;
        }
        
        .social-btn.google:hover {
            background-color: #db4437;
            color: white;
        }
        
        .social-btn.twitter:hover {
            background-color: #1da1f2;
            color: white;
        }
        
        .register-link {
            text-align: center;
            font-size: var(--font-size-sm);
            color: var(--neutral-600);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .demo-accounts {
            margin-top: var(--spacing-lg);
            background-color: var(--secondary);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            position: relative;
            border-left: 4px solid var(--primary);
        }
        
        .demo-accounts-title {
            font-size: var(--font-size-sm);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: var(--spacing-xs);
            display: flex;
            align-items: center;
        }
        
        .demo-accounts-title i {
            margin-right: var(--spacing-xs);
        }
        
        .demo-account-list {
            font-size: var(--font-size-sm);
            color: var(--neutral-700);
            margin: 0;
        }
        
        .demo-account-list dt {
            font-weight: 600;
            display: inline;
        }
        
        .demo-account-list dd {
            display: inline;
            margin: 0;
        }
        
        .demo-accounts-note {
            font-size: var(--font-size-sm);
            color: var(--neutral-600);
            font-style: italic;
            margin-top: var(--spacing-xs);
            margin-bottom: 0;
        }
        
        /* Animation decorations */
        .shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .shape {
            position: absolute;
            z-index: -1;
            opacity: 0.05;
        }
        
        .shape-1 {
            top: 10%;
            right: 10%;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary);
        }
        
        .shape-2 {
            bottom: 15%;
            right: 15%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--accent);
        }
        
        .shape-3 {
            top: 30%;
            left: 5%;
            width: 60px;
            height: 60px;
            background-color: var(--primary-light);
            transform: rotate(45deg);
        }
        
        .shape-4 {
            bottom: 10%;
            left: 15%;
            width: 40px;
            height: 40px;
            background-color: var(--accent-light);
            transform: rotate(30deg);
            border-radius: 8px;
        }
        
        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            vertical-align: text-bottom;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
            margin-right: 0.5rem;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
            }
            
            .login-sidebar, .login-form-container {
                width: 100%;
            }
            
            .login-sidebar {
                padding: var(--spacing-lg);
            }
            
            .login-slogan h1 {
                font-size: var(--font-size-2xl);
            }
            
            .login-features {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .login-logo {
                justify-content: center;
            }
            
            .login-slogan {
                text-align: center;
            }
            
            .login-sidebar-footer {
                text-align: center;
            }
            
            .login-options {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-sm);
            }
            
            .forgot-password {
                display: block;
                margin-top: var(--spacing-xs);
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container" data-aos="fade-up" data-aos-duration="800">
            <!-- Login Sidebar -->
            <div class="login-sidebar">
                <div class="login-sidebar-content">
                    <div class="login-logo">
                        <div class="login-logo-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="login-logo-text">No Food Waste</div>
                    </div>
                    
                    <div class="login-slogan">
                        <h1>Makanan Terselamatkan, Kebaikan Tersalurkan</h1>
                        <p>Bergabunglah dalam misi kami untuk mengurangi pemborosan makanan dan membantu mereka yang membutuhkan.</p>
                    </div>
                    
                    <div class="login-features">
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div>Donasikan makanan berlebih dengan mudah</div>
                        </div>
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>Temukan donasi di sekitar lokasi Anda</div>
                        </div>
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>Bergabung dengan komunitas peduli lingkungan</div>
                        </div>
                    </div>
                </div>
                
                <div class="login-sidebar-footer">
                    <p>&copy; 2025 No Food Waste Initiative. Semua hak dilindungi.</p>
                </div>
            </div>
            
            <!-- Login Form -->
            <div class="login-form-container">
                <div class="shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                </div>
                
                <div class="login-welcome">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Masuk ke akun Anda untuk melanjutkan misi bersama</p>
                </div>
                
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('login.post') }}" id="login-form">
                    @csrf
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        <label for="email">Alamat Email</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        <label for="password">Password</label>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="far fa-eye"></i>
                        </span>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="login-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa password?</a>
                    </div>
                    
                    <button type="submit" class="login-btn" id="login-button">
                        <i class="fas fa-sign-in-alt login-btn-icon"></i>Masuk
                    </button>
                </form>
                
                <div class="auth-separator">
                    <span class="auth-separator-text">atau masuk dengan</span>
                </div>
                
                <div class="social-login">
                    <a href="#" class="social-btn facebook" title="Login dengan Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn google" title="Login dengan Google">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-btn twitter" title="Login dengan Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
                
                <div class="demo-accounts">
                    <div class="demo-accounts-title">
                        <i class="fas fa-info-circle"></i> Akun Demo
                    </div>
                    <dl class="demo-account-list">
                        <dt>Admin:</dt> <dd>admin@gmail.com</dd><br>
                        <dt>Donatur:</dt> <dd>donator@gmail.com</dd><br>
                        <dt>Penerima:</dt> <dd>penerima@gmail.com</dd><br>
                        <dt>Password:</dt> <dd>12345678 (untuk semua akun)</dd>
                    </dl>
                    <p class="demo-accounts-note">* Gunakan akun demo untuk menjelajahi fitur platform</p>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
    <script>
        // Initialize AOS animation library
        AOS.init({
            once: true
        });
        
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Add loading state to button when form is submitted
        document.getElementById('login-form').addEventListener('submit', function() {
            const button = document.getElementById('login-button');
            button.innerHTML = '<span class="spinner"></span>Memproses...';
            button.disabled = true;
        });
    </script>
</body>
</html>
