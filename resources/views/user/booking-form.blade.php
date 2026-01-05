<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - MeetSpace</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f0f4f8;
            min-height: 100vh;
            padding-top: 80px; /* Memberi ruang karena header fixed */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* HEADER FIX: Logo Kiri, Profil Kanan */
        header {
            background: white;
            padding: 0.8rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .logo { 
            font-size: 1.5rem; 
            font-weight: 800; 
            color: #3b82f6; 
            letter-spacing: -1px;
        }

        /* USER MENU & DROPDOWN */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: white;
            min-width: 200px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            z-index: 1001;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            text-decoration: none;
            color: #1e293b;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .dropdown-menu a:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }

        .dropdown-menu a.logout {
            color: #dc2626;
            border-top: 1px solid #f1f5f9;
        }

        .show { display: block; }

        /* FORM STYLING */
        .booking-container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
        }

        .booking-card {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .booking-header h1 { font-size: 1.7rem; color: #1e293b; margin-bottom: 5px; }
        .booking-header p { color: #64748b; font-size: 0.9rem; margin-bottom: 25px; }

        .form-section { margin-bottom: 18px; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-section { flex: 1; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            background: white;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .item-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .item-info h3 {
            margin-bottom: 5px;
            color: #1e293b;
        }

        .item-info p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 480px) {
            .form-row { flex-direction: column; gap: 0; }
            .booking-card { padding: 20px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">MEETSPACE</div>
        
        <div class="user-menu">
            <div class="user-profile" onclick="toggleDropdown()">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <span style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            
            <div id="myDropdown" class="dropdown-menu">
                <a href="{{ route('user.history') }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"></path>
                    </svg>
                    Riwayat Peminjaman
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="dropdown-item logout" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; font: inherit; color: #dc2626; display: flex; align-items: center; gap: 10px; padding: 12px 16px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="booking-container">
        <div class="booking-card">
            <div class="booking-header">
                <a href="{{ route('user.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
                <h1>Detail Pemesanan</h1>
                <p>Silakan lengkapi jadwal peminjaman Anda.</p>
            </div>

            <div class="item-info">
                <h3>{{ $bookable->name }}</h3>
                <p>
                    @if($type === 'room')
                        Kode: {{ $bookable->code }} | Kapasitas: {{ $bookable->capacity }} orang
                    @else
                        Kode Aset: {{ $bookable->asset_code }} | Jumlah: {{ $bookable->quantity }} unit
                    @endif
                </p>
            </div>

            <form method="POST" action="{{ route('user.booking.store') }}">
                @csrf
                <input type="hidden" name="bookable_type" value="{{ $type }}">
                <input type="hidden" name="bookable_id" value="{{ $bookable->id }}">

                <div class="form-section">
                    <label>Tanggal Pakai *</label>
                    <input type="date" name="date" required 
                           min="{{ date('Y-m-d') }}" 
                           value="{{ old('date', date('Y-m-d')) }}">
                    @error('date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-section">
                        <label>Waktu Mulai *</label>
                        <input type="time" name="start_time" required value="{{ old('start_time', '09:00') }}">
                        @error('start_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-section">
                        <label>Waktu Selesai *</label>
                        <input type="time" name="end_time" required value="{{ old('end_time', '10:00') }}">
                        @error('end_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <label>Keperluan *</label>
                    <textarea name="purpose" rows="3" placeholder="Agenda rapat..." required>{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Ajukan Booking</button>
            </form>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.closest('.user-menu')) {
                document.getElementById("myDropdown").classList.remove("show");
            }
        }

        // Set minimum time to current time for today's date
        const dateInput = document.querySelector('input[name="date"]');
        const timeInputs = document.querySelectorAll('input[type="time"]');
        
        dateInput.addEventListener('change', function() {
            const today = new Date().toISOString().split('T')[0];
            const selectedDate = this.value;
            
            if (selectedDate === today) {
                const now = new Date();
                const currentHour = now.getHours().toString().padStart(2, '0');
                const currentMinute = now.getMinutes().toString().padStart(2, '0');
                const currentTime = `${currentHour}:${currentMinute}`;
                
                timeInputs[0].min = currentTime;
                if (timeInputs[0].value < currentTime) {
                    timeInputs[0].value = currentTime;
                }
            } else {
                timeInputs[0].removeAttribute('min');
            }
        });

        // Trigger change event on page load
        dateInput.dispatchEvent(new Event('change'));
    </script>
</body>
</html>