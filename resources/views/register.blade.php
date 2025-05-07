<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | No Food Waste</title>
    
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
        
        .register-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-md);
        }
        
        .register-container {
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
        
        .register-sidebar {
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
        
        .register-sidebar::before {
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
        
        .register-sidebar-content {
            position: relative;
            z-index: 1;
        }
        
        .register-logo {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-xl);
        }
        
        .register-logo-circle {
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
        
        .register-logo-text {
            font-size: var(--font-size-xl);
            font-weight: 700;
        }
        
        .register-slogan {
            margin-bottom: var(--spacing-xl);
        }
        
        .register-slogan h1 {
            font-size: var(--font-size-3xl);
            font-weight: 800;
            margin-bottom: var(--spacing-md);
            line-height: 1.2;
        }
        
        .register-slogan p {
            font-size: var(--font-size-base);
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .register-features {
            margin-bottom: var(--spacing-xl);
        }
        
        .register-feature {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }
        
        .register-feature-icon {
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
        
        .register-sidebar-footer {
            font-size: var(--font-size-sm);
            opacity: 0.8;
        }
        
        .register-form-container {
            padding: var(--spacing-xl);
            width: 60%;
            position: relative;
            overflow: hidden;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .register-welcome {
            margin-bottom: var(--spacing-lg);
            text-align: center;
        }
        
        .register-welcome h2 {
            font-size: var(--font-size-2xl);
            color: var(--neutral-900);
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }
        
        .register-welcome p {
            color: var(--neutral-600);
            font-size: var(--font-size-base);
        }
        
        .form-floating {
            margin-bottom: var(--spacing-md);
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
        
        .register-options {
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
        
        .register-btn {
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
        
        .register-btn:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .register-btn-icon {
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
        
        .social-register {
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
        
        .login-link {
            text-align: center;
            font-size: var(--font-size-sm);
            color: var(--neutral-600);
        }
        
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        /* Role selection cards */
        .role-selection {
            margin-bottom: var(--spacing-lg);
        }
        
        .role-cards {
            display: flex;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }
        
        .role-card {
            flex: 1;
            border: 2px solid var(--neutral-300);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            cursor: pointer;
            transition: var(--transition-normal);
            text-align: center;
            position: relative;
        }
        
        .role-card:hover {
            border-color: var(--primary-light);
            background-color: var(--neutral-50);
            transform: translateY(-2px);
        }
        
        .role-card.selected {
            border-color: var(--primary);
            background-color: rgba(44, 107, 47, 0.05);
        }
        
        .role-card.selected::after {
            content: '✓';
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: var(--primary);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        .role-icon {
            font-size: var(--font-size-2xl);
            color: var(--neutral-700);
            margin-bottom: var(--spacing-sm);
        }
        
        .role-card.selected .role-icon {
            color: var(--primary);
        }
        
        .role-name {
            font-weight: 600;
            color: var(--neutral-800);
        }
        
        .role-description {
            font-size: var(--font-size-sm);
            color: var(--neutral-600);
            margin-top: var(--spacing-xs);
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
            .register-container {
                flex-direction: column;
                max-width: 600px;
            }
            
            .register-sidebar, .register-form-container {
                width: 100%;
            }
            
            .register-sidebar {
                padding: var(--spacing-lg);
            }
            
            .register-slogan h1 {
                font-size: var(--font-size-2xl);
            }
            
            .register-features {
                display: none;
            }
            
            .role-cards {
                flex-direction: column;
            }
        }
        
        @media (max-width: 576px) {
            .register-logo {
                justify-content: center;
            }
            
            .register-slogan {
                text-align: center;
            }
            
            .register-sidebar-footer {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container" data-aos="fade-up" data-aos-duration="800">
            <!-- Register Sidebar -->
            <div class="register-sidebar">
                <div class="register-sidebar-content">
                    <div class="register-logo">
                        <div class="register-logo-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="register-logo-text">No Food Waste</div>
                    </div>
                    
                    <div class="register-slogan">
                        <h1>Bergabung dalam Perubahan</h1>
                        <p>Jadilah bagian dari komunitas yang peduli dengan pengurangan limbah makanan dan distribusi makanan yang lebih baik.</p>
                    </div>
                    
                    <div class="register-features">
                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div>Berkontribusi untuk lingkungan yang lebih baik</div>
                        </div>
                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div>Bantu masyarakat yang membutuhkan</div>
                        </div>
                        <div class="register-feature">
                            <div class="register-feature-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>Dapatkan pengakuan untuk kontribusi Anda</div>
                        </div>
                    </div>
                </div>
                
                <div class="register-sidebar-footer">
                    <p>&copy; 2025 No Food Waste Initiative. Semua hak dilindungi.</p>
                </div>
            </div>
            
            <!-- Register Form -->
            <div class="register-form-container">
                <div class="shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                </div>
                
                <div class="register-welcome">
                    <h2>Buat Akun Baru</h2>
                    <p>Gabung dengan komunitas peduli makanan Indonesia</p>
                </div>
                
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('register.post') }}" id="register-form">
                    @csrf
                    
                    <div class="role-selection">
                        <div class="role-cards">
                            <div class="role-card" onclick="selectRole('donor')">
                                <div class="role-icon">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="role-name">Donatur</div>
                                <div class="role-description">Saya ingin menyumbangkan makanan</div>
                            </div>
                            <div class="role-card" onclick="selectRole('recipient')">
                                <div class="role-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="role-name">Penerima</div>
                                <div class="role-description">Saya ingin menerima donasi</div>
                            </div>
                        </div>
                        <input type="hidden" name="role" id="role-input" value="" required>
                        @error('role')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username"  
                               value="{{ old('username') }}" 
                               required>
                        <label for="username">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
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
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="far fa-eye"></i>
                        </span>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation"  
                               required>
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    
                    <div class="form-floating">
                        <input type="tel" 
                               class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" 
                               name="phone_number" 
                               value="{{ old('phone_number') }}" 
                               required>
                        <label for="phone_number">Nomor Telepon</label>
                        @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating">
                        <textarea 
                               class="form-control @error('address') is-invalid @enderror" 
                               id="address" 
                               name="address" 
                               style="height: 100px"
                               required>{{ old('address') }}</textarea>
                        <label for="address">Alamat</label>
                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="register-options">
                        <div class="form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                  type="checkbox" 
                                  name="terms" 
                                  id="terms" 
                                  required>
                            <label class="form-check-label" for="terms">
                                Saya menyetujui <a href="#" class="text-primary">syarat & ketentuan</a>
                            </label>
                            @error('terms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="register-btn" id="register-button">
                        <i class="fas fa-user-plus register-btn-icon"></i>Daftar Sekarang
                    </button>
                </form>
                
                <div class="auth-separator">
                    <span class="auth-separator-text">atau daftar dengan</span>
                </div>
                
                <div class="social-register">
                    <a href="#" class="social-btn facebook" title="Daftar dengan Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn google" title="Daftar dengan Google">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-btn twitter" title="Daftar dengan Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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
        function togglePassword(id) {
            const passwordInput = document.getElementById(id);
            const icon = passwordInput.nextElementSibling.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Role selection
        function selectRole(role) {
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            const selectedRole = role === 'donor' ? 'donatur' : 'penerima';
            document.getElementById('role-input').value = selectedRole;
            
            if (role === 'donor') {
                document.querySelector('.role-card:nth-child(1)').classList.add('selected');
            } else {
                document.querySelector('.role-card:nth-child(2)').classList.add('selected');
            }
        }
        
        // Add loading state to button when form is submitted
        document.getElementById('register-form').addEventListener('submit', function(e) {
            // Validate if role is selected
            if (!document.getElementById('role-input').value) {
                e.preventDefault();
                alert('Silakan pilih peran Anda sebagai Donatur atau Penerima');
                return;
            }
            
            const button = document.getElementById('register-button');
            button.innerHTML = '<span class="spinner"></span>Memproses...';
            button.disabled = true;
        });
    </script>
</body>
</html>
