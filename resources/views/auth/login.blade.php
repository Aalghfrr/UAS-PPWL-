<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetSpace - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #0ea5e9;
            --brand-gradient: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-body: #f8fafc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: var(--bg-body);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Dekorasi Background Bulatan Halus agar identik dengan Register */
        body::before {
            content: "";
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(14, 165, 233, 0.05);
            border-radius: 50%;
            top: -200px; left: -200px;
        }

        .login-card {
            background: white;
            padding: 50px;
            border-radius: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            z-index: 10;
        }

        .brand-logo {
            font-weight: 800; font-size: 1.2rem;
            color: var(--brand); letter-spacing: -0.5px;
            margin-bottom: 30px; display: block; text-align: center;
        }

        .header h1 { 
            font-size: 2.2rem; 
            font-weight: 800; 
            color: var(--text-main); 
            margin-bottom: 8px; 
            text-align: center;
            letter-spacing: -1px;
        }

        .header p { 
            color: var(--text-muted); 
            margin-bottom: 35px; 
            text-align: center; 
            font-size: 0.95rem;
        }

        .form-group { margin-bottom: 20px; }
        
        .form-group label { 
            display: block; 
            font-size: 0.7rem; 
            font-weight: 700; 
            color: #94a3b8; 
            margin-bottom: 8px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }

        .input-field {
            width: 100%;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1.5px solid #f1f5f9;
            background: #f8fafc;
            font-size: 0.95rem;
            transition: 0.3s;
            color: var(--text-main);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--brand);
            background: white;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--brand-gradient);
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 10px 20px -5px rgba(14, 165, 233, 0.3);
        }

        .btn-login:hover { 
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(14, 165, 233, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-text { 
            text-align: center; 
            margin-top: 30px; 
            font-size: 0.9rem; 
            color: var(--text-muted); 
        }

        .footer-text a { 
            color: var(--brand); 
            text-decoration: none; 
            font-weight: 700; 
            transition: 0.2s;
        }

        .footer-text a:hover {
            color: #0369a1;
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* Responsive Mobile */
        @media (max-width: 500px) {
            .login-card { 
                padding: 30px; 
                border-radius: 0; 
                height: 100vh; 
                max-width: 100%; 
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <span class="brand-logo">MEETSPACE</span>
        <div class="header">
            <h1>Welcome Back</h1>
            <p>Akses kembali ruang kolaborasi Anda.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="input-field" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div style="text-align: right; margin-bottom: 25px;">
                <a href="#" style="font-size: 0.8rem; color: #94a3b8; text-decoration: none; font-weight: 600;">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <p class="footer-text">
            Belum bergabung? <a href="{{ route('register') }}">Daftar Akun Baru</a>
        </p>
    </div>

</body>
</html>