<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | No Food Waste</title>
    
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
        
        .reset-pw-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-md);
        }
        
        .reset-pw-container {
            width: 100%;
            max-width: 550px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
        }
        
        .reset-pw-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: var(--spacing-xl);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .reset-pw-header::before {
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
        
        .reset-pw-logo {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-md);
        }
        
        .reset-pw-logo-circle {
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
        
        .reset-pw-logo-text {
            font-size: var(--font-size-xl);
            font-weight: 700;
        }
        
        .reset-pw-title {
            position: relative;
            z-index: 1;
            font-size: var(--font-size-2xl);
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }
        
        .reset-pw-subtitle {
            position: relative;
            z-index: 1;
            font-size: var(--font-size-base);
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .reset-pw-body {
            padding: var(--spacing-xl);
        }
        
        .form-floating {
            margin-bottom: var(--spacing-lg);
            position: relative;
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
        
        .password-criteria {
            margin-bottom: var(--spacing-lg);
            background-color: var(--secondary);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            border-left: 4px solid var(--primary);
        }
        
        .password-criteria-title {
            font-size: var(--font-size-sm);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: var(--spacing-xs);
            display: flex;
            align-items: center;
        }
        
        .password-criteria-title i {
            margin-right: var(--spacing-xs);
        }
        
        .password-criteria-list {
            font-size: var(--font-size-sm);
            color: var(--neutral-700);
            margin: 0;
            padding-left: var(--spacing-lg);
        }
        
        .password-criteria-list li {
            margin-bottom: var(--spacing-xs);
        }
        
        .password-criteria-list li:last-child {
            margin-bottom: 0;
        }
        
        .confirm-pw-btn {
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
        
        .confirm-pw-btn:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .confirm-pw-btn:active {
            transform: translateY(0);
        }
        
        .confirm-pw-btn-icon {
            margin-right: var(--spacing-sm);
        }
        
        .back-to-login {
            text-align: center;
            font-size: var(--font-size-sm);
            color: var(--neutral-600);
        }
        
        .back-to-login a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        /* Shapes decoration */
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary);
        }
        
        .shape-2 {
            bottom: 15%;
            right: 15%;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--accent);
        }
        
        .shape-3 {
            top: 30%;
            left: 10%;
            width: 40px;
            height: 40px;
            background-color: var(--primary-light);
            transform: rotate(45deg);
        }
        
        .shape-4 {
            bottom: 20%;
            left: 15%;
            width: 30px;
            height: 30px;
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
        @media (max-width: 576px) {
            .reset-pw-title {
                font-size: var(--font-size-xl);
            }
            
            .reset-pw-subtitle {
                font-size: var(--font-size-sm);
            }
            
            .reset-pw-body {
                padding: var(--spacing-lg);
            }
        }
    </style>
</head>
<body>
    <div class="reset-pw-wrapper">
        <div class="reset-pw-container" data-aos="fade-up" data-aos-duration="800">
            <!-- Header -->
            <div class="reset-pw-header">
                <div class="reset-pw-logo">
                    <div class="reset-pw-logo-circle">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="reset-pw-logo-text">No Food Waste</div>
                </div>
                <h1 class="reset-pw-title">Reset Password</h1>
                <p class="reset-pw-subtitle">Buat password baru untuk akun Anda</p>
            </div>
            
            <!-- Body -->
            <div class="reset-pw-body">
                <div class="shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                </div>
                
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('password.update') }}" id="reset-password-form">
                    @csrf
                    
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    
                    <!-- Email Address -->
                    <input type="hidden" name="email" value="{{ $request->email }}">
                    
                    <!-- Password -->
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Password baru"
                               required 
                               autofocus>
                        <label for="password">Password Baru</label>
                        <span class="password-toggle" onclick="togglePassword('password', 'password-toggle')">
                            <i class="far fa-eye" id="password-toggle"></i>
                        </span>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Password Confirmation -->
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi password"
                               required>
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <span class="password-toggle" onclick="togglePassword('password_confirmation', 'confirm-toggle')">
                            <i class="far fa-eye" id="confirm-toggle"></i>
                        </span>
                    </div>
                    
                    <div class="password-criteria">
                        <div class="password-criteria-title">
                            <i class="fas fa-shield-alt"></i> Persyaratan Password
                        </div>
                        <ul class="password-criteria-list">
                            <li>Minimal 8 karakter</li>
                            <li>Mengandung huruf besar dan huruf kecil</li>
                            <li>Mengandung setidaknya satu angka</li>
                            <li>Mengandung setidaknya satu karakter spesial (@, #, $, etc.)</li>
                        </ul>
                    </div>
                    
                    <button type="submit" class="confirm-pw-btn" id="confirm-button">
                        <i class="fas fa-lock confirm-pw-btn-icon"></i>Reset Password
                    </button>
                </form>
                
                <div class="back-to-login">
                    <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Kembali ke halaman login</a>
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
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Add loading state to button when form is submitted
        document.getElementById('reset-password-form').addEventListener('submit', function() {
            const button = document.getElementById('confirm-button');
            button.innerHTML = '<span class="spinner"></span>Memproses...';
            button.disabled = true;
        });
        
        // Password match validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const form = document.getElementById('reset-password-form');
        
        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                alert('Password dan konfirmasi password tidak cocok.');
                confirmPassword.focus();
            }
        });
    </script>
</body>
</html>