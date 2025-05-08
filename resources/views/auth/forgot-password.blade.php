<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | No Food Waste</title>
    
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
        
        .forgot-pw-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-md);
        }
        
        .forgot-pw-container {
            width: 100%;
            max-width: 550px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
        }
        
        .forgot-pw-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: var(--spacing-xl);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .forgot-pw-header::before {
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
        
        .forgot-pw-logo {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-md);
        }
        
        .forgot-pw-logo-circle {
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
        
        .forgot-pw-logo-text {
            font-size: var(--font-size-xl);
            font-weight: 700;
        }
        
        .forgot-pw-title {
            position: relative;
            z-index: 1;
            font-size: var(--font-size-2xl);
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }
        
        .forgot-pw-subtitle {
            position: relative;
            z-index: 1;
            font-size: var(--font-size-base);
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .forgot-pw-body {
            padding: var(--spacing-xl);
        }
        
        .forgot-pw-instructions {
            margin-bottom: var(--spacing-lg);
            padding: var(--spacing-md);
            background-color: var(--secondary);
            border-radius: var(--radius-md);
            border-left: 4px solid var(--primary);
        }
        
        .forgot-pw-instructions-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: var(--spacing-xs);
            display: flex;
            align-items: center;
        }
        
        .forgot-pw-instructions-title i {
            margin-right: var(--spacing-sm);
        }
        
        .forgot-pw-instructions-text {
            color: var(--neutral-700);
            margin-bottom: 0;
            font-size: var(--font-size-base);
        }
        
        .form-floating {
            margin-bottom: var(--spacing-lg);
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
        
        .reset-pw-btn {
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
        
        .reset-pw-btn:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .reset-pw-btn:active {
            transform: translateY(0);
        }
        
        .reset-pw-btn-icon {
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
        
        /* Success message styling */
        .alert-success {
            background-color: #e0f5e9;
            color: #0f5132;
            border-color: #badbcc;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .forgot-pw-title {
                font-size: var(--font-size-xl);
            }
            
            .forgot-pw-subtitle {
                font-size: var(--font-size-sm);
            }
            
            .forgot-pw-body {
                padding: var(--spacing-lg);
            }
        }
    </style>
</head>
<body>
    <div class="forgot-pw-wrapper">
        <div class="forgot-pw-container" data-aos="fade-up" data-aos-duration="800">
            <!-- Header -->
            <div class="forgot-pw-header">
                <div class="forgot-pw-logo">
                    <div class="forgot-pw-logo-circle">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="forgot-pw-logo-text">No Food Waste</div>
                </div>
                <h1 class="forgot-pw-title">Lupa Password</h1>
                <p class="forgot-pw-subtitle">Kami akan mengirimkan link untuk reset password Anda</p>
            </div>
            
            <!-- Body -->
            <div class="forgot-pw-body">
                <div class="shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                </div>
                
                <div class="forgot-pw-instructions">
                    <div class="forgot-pw-instructions-title">
                        <i class="fas fa-info-circle"></i> Petunjuk
                    </div>
                    <p class="forgot-pw-instructions-text">
                        Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk reset password ke email tersebut.
                    </p>
                </div>
                
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form">
                    @csrf
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nama@contoh.com"
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
                    
                    <button type="submit" class="reset-pw-btn" id="reset-button">
                        <i class="fas fa-paper-plane reset-pw-btn-icon"></i>Kirim Link Reset Password
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
        
        // Add loading state to button when form is submitted
        document.getElementById('forgot-password-form').addEventListener('submit', function() {
            const button = document.getElementById('reset-button');
            button.innerHTML = '<span class="spinner"></span>Memproses...';
            button.disabled = true;
        });
    </script>
</body>
</html>