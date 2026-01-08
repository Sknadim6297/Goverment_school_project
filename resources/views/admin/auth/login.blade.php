<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Government School</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --light-bg: #f3f4f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden; /* prevent horizontal scroll */
            width: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: clamp(12px, 3vw, 24px);
            position: relative;
            overflow-x: hidden; /* prevent horizontal scroll */
            overflow-y: auto; /* allow vertical scroll on small screens */
            width: 100%;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: fixed; /* use fixed to prevent overflow */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            pointer-events: none; /* don't block interactions */
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-container {
            background: white;
            border-radius: clamp(12px, 3vw, 20px);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.20);
            overflow: hidden;
            width: 100%;
            min-width: 280px; /* prevent too small on zoom */
            margin: 0 auto; /* center horizontally */
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: clamp(24px, 5vw, 36px) clamp(16px, 4vw, 32px) clamp(18px, 3vw, 24px);
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        .logo-container {
            position: relative; /* contained within header */
            top: 0;
            left: 0;
            transform: none;
            z-index: 1;
            margin-bottom: 12px;
            pointer-events: none; /* avoid blocking clicks */
        }

        .logo-container img {
            display: block;
            height: clamp(70px, 15vw, 96px);
            width: auto;
            max-width: clamp(120px, 25vw, 160px);
            margin: 0 auto;
            object-fit: contain;
            background: transparent; /* no background */
            border-radius: 0; /* no radius wrapper */
            padding: 0; /* no padding around logo */
            box-shadow: none; /* remove box shadow */
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .login-header h1 {
            font-size: clamp(22px, 5vw, 28px);
            margin-top: clamp(8px, 2vw, 10px);
            margin-bottom: clamp(4px, 1vw, 6px);
            font-weight: 700;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        .login-header p {
            font-size: clamp(12px, 2.5vw, 14px);
            opacity: 0.95;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: clamp(20px, 4vw, 28px) clamp(16px, 3vw, 24px);
            background: white;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 35px;
        }

        .welcome-text h2 {
            font-size: 26px;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: #6b7280;
            font-size: 14px;
            font-weight: 400;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            font-size: 16px;
            transition: all 0.3s ease;
            pointer-events: none; /* do not intercept input focus */
        }

        .form-control {
            width: 100%;
            padding: clamp(12px, 2vw, 14px) clamp(14px, 2vw, 18px) clamp(12px, 2vw, 14px) clamp(42px, 8vw, 48px);
            border: 2px solid #e5e7eb;
            border-radius: clamp(8px, 2vw, 12px);
            font-size: clamp(14px, 2.5vw, 15px);
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-control:focus + i {
            color: var(--accent-color);
        }

        .form-control.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 400;
        }

        .error-message::before {
            content: '⚠';
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--secondary-color);
        }

        .remember-me label {
            font-size: 14px;
            color: #4b5563;
            cursor: pointer;
            margin: 0;
            font-weight: 400;
        }

        .btn-login {
            width: 100%;
            padding: clamp(14px, 3vw, 16px);
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: clamp(8px, 2vw, 12px);
            font-size: clamp(14px, 2.5vw, 16px);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(8px, 2vw, 12px);
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login span,
        .btn-login i {
            position: relative;
            z-index: 1;
        }

        .login-footer {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #6b7280;
            font-size: 13px;
            font-weight: 400;
        }

        .login-footer i {
            color: #ef4444;
            margin: 0 3px;
        }

        @media (max-width: 480px) {
            body {
                padding: 8px;
            }
            
            .login-wrapper {
                width: 100%;
            }
            
            .login-container {
                min-width: 100%;
                margin: 0;
            }

            .input-group i {
                left: 14px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 360px) {
            body {
                padding: 4px;
            }
            
            .login-container {
                border-radius: 8px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo-container">
                    <img src="{{ asset('admin/images/logo/school_logo.png') }}" 
                         alt="School Logo" 
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%231e3a8a%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2240%22 fill=%22white%22 font-weight=%22bold%22%3EGS%3C/text%3E%3C/svg%3E'">
                </div>
                <h1>Admin Login</h1>
                <p>Sign in to access the dashboard</p>
            </div>

            <div class="login-body">
   

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </span>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control @error('email') error @enderror" 
                                   placeholder="Enter your email address"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                            <i class="fas fa-envelope"></i>
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') error @enderror" 
                                   placeholder="Enter your password"
                                   required>
                            <i class="fas fa-lock"></i>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sign In to Dashboard</span>
                    </button>
                </form>
            </div>


        </div>
    </div>
</body>
</html>
