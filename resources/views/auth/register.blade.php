<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetSpace - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #0ea5e9;
            --brand-gradient: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Dekorasi Background Modern */
        body::before {
            content: "";
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(14, 165, 233, 0.05);
            border-radius: 50%;
            top: -200px; right: -200px;
        }

        .reg-card {
            background: white;
            padding: 50px;
            border-radius: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            z-index: 10;
        }

        .brand-logo {
            font-weight: 800; font-size: 1.2rem;
            color: var(--brand); letter-spacing: -0.5px;
            margin-bottom: 30px; display: block; text-align: center;
        }

        .header h1 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 8px; text-align: center;}
        .header p { color: #64748b; margin-bottom: 35px; text-align: center; font-size: 0.95rem;}

        .grid-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .full-width { grid-column: span 2; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.7rem; font-weight: 700; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; }

        .input-field {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid #f1f5f9;
            background: #f8fafc;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--brand);
            background: white;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .btn-reg {
            width: 100%;
            padding: 16px;
            background: var(--brand-gradient);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
            box-shadow: 0 10px 20px -5px rgba(14, 165, 233, 0.3);
        }

        .btn-reg:hover { transform: scale(1.02); }

        .footer-text { text-align: center; margin-top: 30px; font-size: 0.9rem; color: #64748b; }
        .footer-text a { color: var(--brand); text-decoration: none; font-weight: 700; }

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .grid-inputs { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .reg-card { padding: 30px; border-radius: 0; height: 100vh; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <span class="brand-logo">MEETSPACE</span>
        <div class="header">
            <h1>Create Account</h1>
            <p>Bergabunglah dengan ekosistem MeetSpace.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid-inputs">
                <div class="form-group full-width">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="input-field" placeholder="Masukan Nama Lengkap" required value="{{ old('name') }}">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group full-width">
                    <label>Email</label>
                    <input type="email" name="email" class="input-field" placeholder="Masukan Email" required value="{{ old('email') }}">
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
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input-field" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-reg">Lest Go</button>
        </form>

        <p class="footer-text">
            Sudah punya akun? <a href="{{ route('login') }}">Sign In</a>
        </p>
    </div>

</body>
</html>