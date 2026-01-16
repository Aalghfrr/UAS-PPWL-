<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetSpace - Booking System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* HEADER UTAMA */
        header {
            background: white;
            padding: 0.8rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1001;
        }

        .logo { 
            font-size: 1.5rem; 
            font-weight: 800; 
            color: #3b82f6; 
            letter-spacing: -1px;
        }

        /* NAVBAR KATEGORI */
        .category-nav {
            background: #ffffff;
            padding: 0.6rem 5%;
            display: flex;
            gap: 15px;
            position: sticky;
            top: 60px; 
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            justify-content: center;
        }

        .category-nav a {
            text-decoration: none;
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 20px;
            background: #f9fafb;
            transition: 0.3s;
        }

        .category-nav a:hover {
            background: #3b82f6;
            color: white;
        }

        /* USER MENU & DROPDOWN FIX */
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
            top: 115%;
            background: white;
            min-width: 210px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            z-index: 1002;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: #1e293b;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .dropdown-menu a svg {
            flex-shrink: 0;
            color: #64748b;
        }

        .dropdown-menu a:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }

        .dropdown-menu a:hover svg {
            color: #3b82f6;
        }

        .dropdown-menu a.logout {
            color: #dc2626;
            border-top: 1px solid #f1f5f9;
        }

        .dropdown-menu a.logout svg {
            color: #dc2626;
        }

        .show { display: block; }

        /* CONTAINER & CARDS */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .section-header {
            margin: 40px 0 20px;
            font-size: 1.5rem;
            color: #111827;
            border-left: 4px solid #3b82f6;
            padding-left: 15px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: 0.3s;
        }

        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0,0,0,0.08); }
        .card-img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 20px; }

        .status-badge {
            display: flex;
            align-items: center;
            margin: 15px 0;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .dot { height: 8px; width: 8px; border-radius: 50%; margin-right: 8px; }
        .available { color: #059669; }
        .available .dot { background: #10b981; box-shadow: 0 0 8px #10b981; }
        .unavailable { color: #dc2626; }
        .unavailable .dot { background: #ef4444; }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .btn-blue { background: #3b82f6; color: white; }
        .btn-blue:hover { background: #2563eb; }
        .btn-blue:disabled { background: #d1d5db; cursor: not-allowed; }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
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
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Riwayat Peminjaman
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="dropdown-item logout" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; font: inherit; color: #dc2626; display: flex; align-items: center; gap: 12px; padding: 12px 16px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <nav class="category-nav">
        <a href="#ruangan">📍 Daftar Ruangan</a>
        <a href="#elektronik">💻 Fasilitas </a>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div id="ruangan">
            <h2 class="section-header">Ruangan Rapat</h2>
            <div class="grid-container">
                @foreach($rooms as $room)
                <div class="card">
                    <img src="{{ asset('storage/' . $room->image) }}" class="card-img" alt="{{ $room->name }}">
                    <div class="card-body">
                        <h3>{{ $room->name }}</h3>
                        <p style="color:#6b7280; font-size: 0.85rem; margin-top: 5px;">{{ $room->description }}</p>
                        <div class="status-badge {{ $room->isAvailable() ? 'available' : 'unavailable' }}">
                            <span class="dot"></span> 
                            {{ $room->isAvailable() ? 'Tersedia' : 'Tidak Tersedia' }}
                        </div>
                        @if($room->isAvailable())
                        <a href="{{ route('user.booking.form', ['type' => 'room', 'id' => $room->id]) }}" class="btn btn-blue">Booking Ruangan</a>
                        @else
                        <button class="btn btn-blue" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="elektronik">
            <h2 class="section-header">Fasilitas Elektronik</h2>
            <div class="grid-container">
                @foreach($facilities as $facility)
                <div class="card">
                    <img src="{{ asset('storage/' . $facility->image) }}" class="card-img" alt="{{ $facility->name }}">
                    <div class="card-body">
                        <h3>{{ $facility->name }}</h3>
                        <p style="color:#6b7280; font-size: 0.85rem; margin-top: 5px;">{{ $facility->description }}</p>
                        <div class="status-badge {{ $facility->isAvailable() ? 'available' : 'unavailable' }}">
                            <span class="dot"></span> 
                            {{ $facility->isAvailable() ? $facility->quantity . ' Unit Tersedia' : 'Tidak Tersedia' }}
                        </div>
                        @if($facility->isAvailable())
                        <a href="{{ route('user.booking.form', ['type' => 'facility', 'id' => $facility->id]) }}" class="btn btn-blue">Pinjam Sekarang</a>
                        @else
                        <button class="btn btn-blue" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Menutup dropdown jika user mengklik di luar menu
        window.onclick = function(event) {
            if (!event.target.closest('.user-menu')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>