<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MeetSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #0ea5e9;
            --brand-gradient: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            --bg: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg); color: var(--text-main); }

        /* HEADER */
        header {
            background: var(--white);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-size: 1.5rem; font-weight: 800; color: var(--brand); letter-spacing: -1px; }

        /* DROPDOWN STYLES */
        .user-menu {
            position: relative;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 16px;
            background: #f1f5f9;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .admin-profile:hover {
            background: #e0f2fe;
            border-color: var(--brand);
        }

        .avatar {
            width: 32px; height: 32px;
            background: var(--brand-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 220px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
            padding: 8px;
            display: none;
            z-index: 1001;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background: #f0f9ff;
            color: var(--brand);
        }

        .dropdown-item svg {
            color: var(--text-muted);
        }

        .dropdown-item:hover svg {
            color: var(--brand);
        }

        .dropdown-item.logout {
            color: #ef4444;
            border-top: 1px solid #f1f5f9;
            border-radius: 0 0 10px 10px;
            margin-top: 4px;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
        }

        /* CONTAINER */
        .container { width: 90%; max-width: 1200px; margin: 40px auto; }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .stat-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-blue { background: #e0f2fe; color: #0ea5e9; }
        .icon-purple { background: #f3e8ff; color: #8b5cf6; } /* Warna baru untuk fasilitas */
        .icon-yellow { background: #fef9c3; color: #ca8a04; }
        .icon-red { background: #fee2e2; color: #ef4444; }

        .stat-info h3 { 
            font-size: 0.85rem; 
            color: var(--text-muted); 
            font-weight: 600; 
            margin-bottom: 5px;
        }
        .stat-info p { 
            font-size: 1.8rem; 
            font-weight: 800; 
            margin: 0;
        }

        /* SECTION STYLE */
        .section-card {
            background: var(--white);
            border-radius: 32px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 { 
            font-size: 1.25rem; 
            font-weight: 800; 
            letter-spacing: -0.5px; 
            margin: 0;
        }

        /* TABLE */
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        
        th { 
            text-align: left; 
            font-size: 0.75rem; 
            color: var(--text-muted); 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            padding: 15px 10px; 
            border-bottom: 2px solid #f8fafc; 
            font-weight: 700;
        }
        
        td { 
            padding: 20px 10px; 
            border-bottom: 1px solid #f8fafc; 
            font-size: 0.9rem; 
            vertical-align: middle;
        }

        .user-info div { 
            font-weight: 700; 
            margin-bottom: 5px;
        }
        
        .user-info small { 
            color: var(--text-muted); 
            font-size: 0.8rem;
        }

        .room-tag { 
            font-weight: 700; 
            color: var(--brand); 
            margin-bottom: 5px;
            display: block;
        }

        /* BUTTONS */
        .btn-group { 
            display: flex; 
            gap: 8px; 
            flex-wrap: wrap;
        }
        
        .btn-action {
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            white-space: nowrap;
        }

        .btn-approve { 
            background: #dcfce7; 
            color: #16a34a; 
        }
        
        .btn-approve:hover { 
            background: #16a34a; 
            color: white; 
        }
        
        .btn-reject { 
            background: #fee2e2; 
            color: #dc2626; 
        }
        
        .btn-reject:hover { 
            background: #dc2626; 
            color: white; 
        }

        /* BOTTOM NAV GRID */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .manage-card {
            background: var(--white);
            padding: 24px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: 0.3s;
            border: 1px solid #f1f5f9;
            text-decoration: none;
            color: inherit;
        }

        .manage-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); 
            border-color: var(--brand);
        }

        .manage-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            background: var(--brand-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .manage-info h4 { 
            font-size: 1rem; 
            font-weight: 700; 
            margin-bottom: 5px;
        }
        
        .manage-info p { 
            font-size: 0.85rem; 
            color: var(--text-muted); 
            margin: 0;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #eff6ff; 
            color: #3b82f6;
        }

        footer {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 50px;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }
        
        .empty-state svg {
            margin-bottom: 15px;
            color: #cbd5e1;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">MEETSPACE</div>
        
        <div class="user-menu">
            <div class="admin-profile" id="profileTrigger">
                <div class="avatar">AD</div>
                <span style="font-weight: 700; font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>

            <div class="dropdown-menu" id="adminDropdown">
                <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="dropdown-item logout" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; font: inherit;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        
        <!-- STATS GRID -->
        <div class="stats-grid">
            <!-- Total Ruangan -->
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Total Ruangan</h3>
                    <p>{{ $totalRooms ?? 0 }}</p>
                </div>
            </div>
            
            <!-- Total Fasilitas (DIPERBAIKI) -->
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Total Fasilitas</h3>
                    <p>{{ $totalFacilities ?? 0 }}</p>
                </div>
            </div>
            
            <!-- Pending Bookings -->
            <div class="stat-card">
                <div class="stat-icon icon-yellow">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Pending</h3>
                    <p>{{ $pendingBookings ?? 0 }}</p>
                </div>
            </div>
            
            <!-- Rejected Bookings -->
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Ditolak</h3>
                    <p>{{ $rejectedBookings ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- PENDING APPROVALS SECTION -->
        <div class="section-card">
            <div class="section-header">
                <h2>Persetujuan Booking</h2>
                <span class="status-pill">{{ $pendingBookings ?? 0 }} Menunggu</span>
            </div>
            
            @if($pendingApprovals && $pendingApprovals->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Ruangan/Fasilitas</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingApprovals as $booking)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div>{{ $booking->user->name ?? 'N/A' }}</div>
                                    <small>{{ $booking->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="room-tag">
                                    @if(isset($booking->bookable))
                                        {{ $booking->bookable->name ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                                <small style="color:#94a3b8">
                                    @if($booking->bookable_type === 'App\Models\Room')
                                        Ruangan
                                    @else
                                        Fasilitas
                                    @endif
                                </small>
                            </td>
                            <td>
                                @if($booking->date)
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($booking->start_time && $booking->end_time)
                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-approve">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="admin_notes" value="Booking ditolak oleh admin">
                                        <button type="submit" class="btn-action btn-reject">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Tidak ada booking yang menunggu persetujuan</h3>
                </div>
            @endif
        </div>

        <!-- MANAGEMENT CARDS -->
        <div class="management-grid">
            <a href="{{ route('admin.rooms') }}" class="manage-card">
                <div class="manage-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="manage-info">
                    <h4>Kelola Ruangan</h4>
                    <p>Tambah, edit, atau hapus unit ruangan.</p>
                </div>
            </a>
            
            <a href="{{ route('admin.facilities') }}" class="manage-card">
                <div class="manage-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="manage-info">
                    <h4>Kelola Fasilitas</h4>
                    <p>Manajemen peralatan elektronik.</p>
                </div>
            </a>
            
            <a href="{{ route('admin.bookings') }}" class="manage-card">
                <div class="manage-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="manage-info">
                    <h4>Semua Booking</h4>
                    <p>Lihat seluruh riwayat transaksi.</p>
                </div>
            </a>
        </div>

    </div>

    <footer>
        &copy; {{ date('Y') }} MeetSpace Admin Panel. All rights reserved.
    </footer>

    <script>
        const profileTrigger = document.getElementById('profileTrigger');
        const adminDropdown = document.getElementById('adminDropdown');

        // Toggle dropdown on click
        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            adminDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking anywhere else
        window.addEventListener('click', (e) => {
            if (!profileTrigger.contains(e.target)) {
                adminDropdown.classList.remove('active');
            }
        });
    </script>

</body>
</html>