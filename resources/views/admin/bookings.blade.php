<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Booking - MeetSpace Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #0ea5e9;
            --brand-gradient: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            --bg: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
            --pending: #f59e0b;
            --approved: #10b981;
            --rejected: #ef4444;
            --completed: #3b82f6;
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

        .dropdown-item.logout {
            color: #ef4444;
            border-top: 1px solid #f1f5f9;
            border-radius: 0 0 10px 10px;
            margin-top: 4px;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
        }

        /* MAIN CONTENT */
        .container { width: 90%; max-width: 1400px; margin: 30px auto; }

        /* BACK BUTTON */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 25px;
            padding: 8px 16px;
            border-radius: 10px;
            transition: 0.2s;
        }

        .back-button:hover {
            background: #f1f5f9;
            color: var(--brand);
        }

        /* HEADER SECTION */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .section-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid #f1f5f9;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .stat-title {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .stat-total { border-top: 4px solid var(--brand); }
        .stat-pending { border-top: 4px solid var(--pending); }
        .stat-approved { border-top: 4px solid var(--approved); }
        .stat-rejected { border-top: 4px solid var(--rejected); }

        /* FILTER SECTION */
        .filter-section {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #f1f5f9;
        }

        .filter-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text-main);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .filter-select, .filter-input {
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
        }

        .filter-select:focus, .filter-input:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-filter {
            padding: 10px 24px;
            border-radius: 10px;
            border: none;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-apply {
            background: var(--brand-gradient);
            color: white;
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        }

        .btn-reset {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-reset:hover {
            background: #e2e8f0;
        }

        /* TABLE STYLES */
        .table-container {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            margin-bottom: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        td {
            padding: 18px 20px;
            font-size: 0.9rem;
            color: var(--text-main);
            vertical-align: middle;
        }

        /* STATUS BADGES */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-approved {
            background: #d1fae5;
            color: #059669;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        /* TYPE BADGES */
        .type-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-room {
            background: #e0f2fe;
            color: #0369a1;
        }

        .badge-facility {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-approve:hover {
            background: #059669;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-reject:hover {
            background: #dc2626;
        }

        .btn-complete {
            background: #3b82f6;
            color: white;
        }

        .btn-complete:hover {
            background: #2563eb;
        }

        .btn-view {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-view:hover {
            background: #e2e8f0;
        }

        .btn-action:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* USER INFO */
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--brand-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* PAGINATION */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination-link {
            padding: 10px 16px;
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .pagination-link:hover {
            background: #f1f5f9;
            border-color: var(--brand);
        }

        .pagination-link.active {
            background: var(--brand);
            color: white;
            border-color: var(--brand);
        }

        .pagination-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ALERTS */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-icon {
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--text-main);
            font-weight: 700;
        }

        .empty-description {
            font-size: 0.9rem;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 30px 20px;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid #e2e8f0;
            margin-top: 50px;
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
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Dashboard
                </a>
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
        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" class="back-button">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Dashboard
        </a>

        <!-- Alerts -->
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

        <!-- Header -->
        <div class="section-header">
            <h1>Semua Booking</h1>
            <div style="font-size: 0.9rem; color: var(--text-muted);">
                Total: {{ $stats['total'] }} booking
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="stat-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Total Booking
                </div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
            
            <div class="stat-card stat-pending">
                <div class="stat-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Pending
                </div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
            </div>
            
            <div class="stat-card stat-approved">
                <div class="stat-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Disetujui
                </div>
                <div class="stat-value">{{ $stats['approved'] }}</div>
            </div>
            
            <div class="stat-card stat-rejected">
                <div class="stat-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Ditolak
                </div>
                <div class="stat-value">{{ $stats['rejected'] }}</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">Filter Booking</div>
            <form method="GET" action="{{ route('admin.bookings') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Tipe</label>
                        <select name="type" class="filter-select">
                            <option value="">Semua Tipe</option>
                            <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Ruangan</option>
                            <option value="facility" {{ request('type') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Tanggal Booking</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="filter-input">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Cari User</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="filter-input">
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn-filter btn-apply">Terapkan Filter</button>
                    <a href="{{ route('admin.bookings') }}" class="btn-filter btn-reset">Reset Filter</a>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="table-container">
            @if($bookings->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Tipe</th>
                            <th>Item</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Tanggal Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ substr($booking->user->name, 0, 2) }}
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $booking->user->name }}</div>
                                        <div class="user-email">{{ $booking->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($booking->bookable_type == 'App\Models\Room')
                                    <span class="type-badge badge-room">Ruangan</span>
                                @else
                                    <span class="type-badge badge-facility">Fasilitas</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $booking->bookable->name ?? 'Item dihapus' }}</strong>
                                @if($booking->bookable_type == 'App\Models\Facility' && $booking->bookable)
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        Kode: {{ $booking->bookable->code ?? 'N/A' }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ $booking->date ? \Carbon\Carbon::parse($booking->date)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td>
                                @if($booking->start_time && $booking->end_time)
                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="status-badge badge-pending">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($booking->status == 'approved')
                                    <span class="status-badge badge-approved">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Disetujui
                                    </span>
                                @elseif($booking->status == 'rejected')
                                    <span class="status-badge badge-rejected">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="status-badge badge-completed">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $booking->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-approve" title="Setujui">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-reject" title="Tolak">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($booking->status == 'approved')
                                        <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-complete" title="Selesaikan">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button class="btn-action btn-view" title="Lihat Detail" onclick="showBookingDetails({{ $booking->id }})">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">Belum ada booking</h3>
                    <p class="empty-description">
                        @if(request()->hasAny(['status', 'type', 'date', 'search']))
                            Tidak ada booking yang sesuai dengan filter yang dipilih.
                        @else
                            Saat ini belum ada booking yang dibuat oleh pengguna.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="pagination">
                @if($bookings->onFirstPage())
                    <span class="pagination-link disabled">&laquo; Sebelumnya</span>
                @else
                    <a href="{{ $bookings->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" class="pagination-link">&laquo; Sebelumnya</a>
                @endif

                @foreach(range(1, $bookings->lastPage()) as $page)
                    @if($page == $bookings->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $bookings->url($page) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" class="pagination-link">Berikutnya &raquo;</a>
                @else
                    <span class="pagination-link disabled">Berikutnya &raquo;</span>
                @endif
            </div>
        @endif
    </div>

    <footer>
        © 2025 MeetSpace Admin Panel. All rights reserved.
    </footer>

    <script>
        // Dropdown menu functionality
        const profileTrigger = document.getElementById('profileTrigger');
        const adminDropdown = document.getElementById('adminDropdown');

        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            adminDropdown.classList.toggle('active');
        });

        window.addEventListener('click', (e) => {
            if (!profileTrigger.contains(e.target)) {
                adminDropdown.classList.remove('active');
            }
        });

        // Show booking details (placeholder function)
        function showBookingDetails(bookingId) {
            alert('Detail booking ID: ' + bookingId + '\nFitur ini dapat dikembangkan lebih lanjut untuk menampilkan detail lengkap booking.');
            // Anda dapat menambahkan modal untuk menampilkan detail lengkap booking
        }

        // Confirm actions
        document.querySelectorAll('form[action*="approve"], form[action*="reject"], form[action*="complete"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const action = this.action.includes('approve') ? 'menyetujui' : 
                              this.action.includes('reject') ? 'menolak' : 'menyelesaikan';
                if (!confirm(`Apakah Anda yakin ingin ${action} booking ini?`)) {
                    e.preventDefault();
                }
            });
        });

        // Auto-submit filter on change (optional)
        document.querySelectorAll('.filter-select, .filter-input').forEach(element => {
            element.addEventListener('change', function() {
                if (this.name === 'search') return; // Don't auto-submit on search
                this.form.submit();
            });
        });
    </script>
</body>
</html>