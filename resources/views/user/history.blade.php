<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - MeetSpace</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f3f4f6;
            color: #1f2937;
            padding-top: 80px;
        }

        /* HEADER */
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

        /* USER MENU */
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

        /* CONTENT */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
        }

        .btn-back {
            text-decoration: none;
            color: #3b82f6;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #f9fafb;
            padding: 15px 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 18px 20px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-completed { background: #e0f2fe; color: #1e40af; }

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

        @media (max-width: 768px) {
            .table-container { overflow-x: auto; }
            table { min-width: 700px; }
            .header-area { flex-direction: column; align-items: flex-start; gap: 15px; }
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
        </div>
    </header>

    <div class="container">
        <div class="header-area">
            <div>
                <a href="{{ route('user.dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
                <h1>Riwayat Peminjaman</h1>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.9rem;">Total Peminjaman: <strong>{{ $bookings->count() }}</strong></p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ruangan / Fasilitas</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>
                            <strong>{{ $booking->bookable->name }}</strong><br>
                            <small style="color:#9ca3af">
                                @if($booking->bookable_type === 'App\Models\Room')
                                    Ruangan
                                @else
                                    Fasilitas
                                @endif
                            </small>
                        </td>
                        <td>{{ $booking->date->format('d M Y') }}</td>
                        <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                        <td>{{ Str::limit($booking->purpose, 30) }}</td>
                        <td>
                            @if($booking->status === 'pending')
                                <span class="status status-pending">Menunggu</span>
                            @elseif($booking->status === 'approved')
                                <span class="status status-approved">Disetujui</span>
                            @elseif($booking->status === 'rejected')
                                <span class="status status-rejected">Ditolak</span>
                            @else
                                <span class="status status-completed">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($bookings->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #6b7280;">
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
    </script>
</body>
</html>