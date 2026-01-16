<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan - MeetSpace</title>
    
    <!-- ⚡ FORCE NO CACHE - INI SOLUSI UTAMA -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- ⚡ DISABLE BROWSER CACHE -->
    <script>
        if (performance.navigation.type === 2) {
            // Jika navigasi via back button, force reload
            location.reload(true);
        }
    </script>
</head>
<body>
    <!-- ⚡ ADD NO-CACHE HEADERS VIA PHP -->
    <?php
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>

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
        body { background-color: var(--bg); color: var(--text-main); padding-bottom: 50px; }

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
        .container { width: 90%; max-width: 1200px; margin: 30px auto; }

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
        }

        .section-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* ADD ROOM BUTTON */
        .btn-add {
            background: var(--brand-gradient);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        }

        /* ROOMS GRID */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .room-card {
            background: var(--white);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            transition: 0.3s;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        }

        .room-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #f1f5f9;
        }

        .room-default-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            border-bottom: 1px solid #f1f5f9;
        }

        .room-info {
            padding: 20px;
        }

        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .room-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .room-code {
            font-size: 0.85rem;
            color: var(--brand);
            font-weight: 700;
            background: #f0f9ff;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .room-details {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .room-detail {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .room-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .status-available { background: #dcfce7; color: #16a34a; }
        .status-maintenance { background: #fef9c3; color: #ca8a04; }
        .status-unavailable { background: #fee2e2; color: #dc2626; }

        .room-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            flex: 1;
        }

        .btn-edit { background: #f1f5f9; color: #475569; }
        .btn-edit:hover { background: #e2e8f0; }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #dc2626; color: white; }

        /* MODAL STYLES */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: 32px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .btn-close:hover {
            color: var(--text-main);
        }

        /* FORM STYLES */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            background-color: white;
            cursor: pointer;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* FILE UPLOAD STYLES */
        .file-upload {
            position: relative;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-upload:hover {
            border-color: var(--brand);
            background: #f0f9ff;
        }

        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-icon {
            margin-bottom: 15px;
        }

        .file-upload-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .file-upload-hint {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .image-preview {
            margin-top: 15px;
            display: none;
        }

        .image-preview img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .remove-image {
            margin-top: 10px;
            background: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .remove-image:hover {
            background: #dc2626;
            color: white;
        }

        /* FORM BUTTONS */
        .form-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn-submit {
            background: var(--brand-gradient);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            flex: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            flex: 1;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        /* DELETE MODAL */
        .delete-modal-content {
            text-align: center;
            padding: 40px 30px;
        }

        .delete-icon {
            width: 60px;
            height: 60px;
            background: #fee2e2;
            color: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .delete-modal-content h3 {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .delete-modal-content p {
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .delete-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-delete-confirm {
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            flex: 1;
        }

        .btn-delete-confirm:hover {
            background: #b91c1c;
        }

        .btn-delete-cancel {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            flex: 1;
        }

        .btn-delete-cancel:hover {
            background: #e2e8f0;
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
    </style>

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

        <!-- ⚡ AUTO-REFRESH ALERT -->
        @if(session('success'))
            <div class="alert alert-success" id="successAlert">
                {{ session('success') }}
                <span style="float: right; font-weight: normal;">
                    (Refreshing in <span id="countdown">3</span>s)
                </span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="section-header">
            <h1>Kelola Ruangan</h1>
            <div style="display: flex; gap: 10px;">
                <!-- ⚡ FORCE REFRESH BUTTON -->
                <button class="btn-add" onclick="forceRefresh()" style="background: #64748b;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Force Refresh
                </button>
                <button class="btn-add" onclick="openAddModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Tambah Ruangan
                </button>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div class="rooms-grid">
            @foreach($rooms as $room)
            <div class="room-card">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) . '?v=' . time() }}" alt="{{ $room->name }}" class="room-image">
                @else
                    <div class="room-default-image">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                @endif
                <div class="room-info">
                    <div class="room-header">
                        <div>
                            <div class="room-name">{{ $room->name }}</div>
                            <div class="room-code">{{ $room->code }}</div>
                        </div>
                        <div class="room-status status-{{ $room->status }}">
                            @if($room->status == 'available')
                                Tersedia
                            @elseif($room->status == 'maintenance')
                                Maintenance
                            @else
                                Tidak Tersedia
                            @endif
                        </div>
                    </div>
                    
                    <div class="room-details">
                        <div class="room-detail">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ $room->capacity }} orang
                        </div>
                    </div>
                    
                    @if($room->description)
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px; line-height: 1.5;">
                            {{ Str::limit($room->description, 100) }}
                        </p>
                    @endif
                    
                    <div class="room-actions">
                        <button class="btn-action btn-edit" onclick="openEditModal({{ $room->id }}, '{{ addslashes($room->name) }}', '{{ $room->code }}', {{ $room->capacity }}, '{{ $room->status }}', `{{ addslashes($room->description) }}`, `{{ $room->image }}`)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 5px;">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Edit
                        </button>
                        <button class="btn-action btn-delete" onclick="openDeleteModal({{ $room->id }}, '{{ addslashes($room->name) }}')">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 5px;">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            
            @if($rooms->isEmpty())
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 20px;">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Belum ada ruangan</h3>
                <p style="font-size: 0.9rem;">Klik tombol "Tambah Ruangan" untuk menambahkan ruangan pertama</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah Ruangan Baru</h2>
                <button class="btn-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" id="addForm">
                @csrf
                <div class="form-group">
                    <label for="add_name">Nama Ruangan *</label>
                    <input type="text" id="add_name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="add_code">Kode Ruangan *</label>
                    <input type="text" id="add_code" name="code" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="add_capacity">Kapasitas *</label>
                    <input type="number" id="add_capacity" name="capacity" class="form-control" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="add_status">Status *</label>
                    <select id="add_status" name="status" class="form-select" required>
                        <option value="available">Tersedia</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>
                
                <!-- FILE UPLOAD SECTION -->
                <div class="form-group">
                    <label for="add_image">Foto Ruangan</label>
                    <div class="file-upload" id="addFileUpload">
                        <div class="file-upload-icon">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="file-upload-text">Klik untuk upload foto</div>
                        <div class="file-upload-hint">Format: JPG, PNG, JPEG (Max: 2MB)</div>
                        <input type="file" id="add_image" name="image" accept="image/*" onchange="previewImage(event, 'addPreview')">
                    </div>
                    <div class="image-preview" id="addPreview">
                        <img id="addPreviewImage" src="#" alt="Preview">
                        <button type="button" class="remove-image" onclick="removeImage('add_image', 'addPreview')">Hapus Gambar</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="add_description">Deskripsi</label>
                    <textarea id="add_description" name="description" class="form-control form-textarea" rows="3"></textarea>
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Ruangan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Ruangan</h2>
                <button class="btn-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_name">Nama Ruangan *</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_code">Kode Ruangan *</label>
                    <input type="text" id="edit_code" name="code" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_capacity">Kapasitas *</label>
                    <input type="number" id="edit_capacity" name="capacity" class="form-control" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Status *</label>
                    <select id="edit_status" name="status" class="form-select" required>
                        <option value="available">Tersedia</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>
                
                <!-- FILE UPLOAD SECTION FOR EDIT -->
                <div class="form-group">
                    <label for="edit_image">Foto Ruangan</label>
                    <div id="currentImageContainer" style="margin-bottom: 15px;"></div>
                    <div class="file-upload" id="editFileUpload">
                        <div class="file-upload-icon">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="file-upload-text">Klik untuk ganti foto</div>
                        <div class="file-upload-hint">Format: JPG, PNG, JPEG (Max: 2MB)</div>
                        <input type="file" id="edit_image" name="image" accept="image/*" onchange="previewImage(event, 'editPreview')">
                    </div>
                    <div class="image-preview" id="editPreview">
                        <img id="editPreviewImage" src="#" alt="Preview">
                        <button type="button" class="remove-image" onclick="removeImage('edit_image', 'editPreview')">Hapus Gambar</button>
                    </div>
                    <input type="hidden" id="remove_image" name="remove_image" value="0">
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Deskripsi</label>
                    <textarea id="edit_description" name="description" class="form-control form-textarea" rows="3"></textarea>
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-submit" onclick="handleEditSubmit(event)">Update Ruangan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content delete-modal-content">
            <div class="delete-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Hapus Ruangan</h3>
            <p id="deleteMessage">Apakah Anda yakin ingin menghapus ruangan ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="delete-buttons">
                <button class="btn-delete-cancel" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline; flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-confirm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // FORCE REFRESH FUNCTION
        function forceRefresh() {
            console.log('Force refreshing page...');
            // Clear localStorage dan sessionStorage
            localStorage.clear();
            sessionStorage.clear();
            
            // Force reload dengan cache bypass
            window.location.href = window.location.href + '?force=' + Date.now();
        }

        // AUTO-REFRESH AFTER SUCCESS
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                let countdown = 3;
                const countdownElement = document.getElementById('countdown');
                
                const timer = setInterval(function() {
                    countdown--;
                    countdownElement.textContent = countdown;
                    
                    if (countdown <= 0) {
                        clearInterval(timer);
                        forceRefresh();
                    }
                }, 1000);
            }
            
            // ⚡ FORCE CHECK FOR UPDATES
            console.log('Page loaded at:', new Date().toLocaleTimeString());
            console.log('Rooms data timestamp:', '{{ now() }}');
        });

        // Modal functions
        function openAddModal() {
            document.getElementById('addModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.remove('active');
            document.getElementById('addForm').reset();
            document.getElementById('addPreview').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function openEditModal(id, name, code, capacity, status, description, image) {
            console.log('Opening edit modal for room ID:', id, 'Status:', status);
            
            document.getElementById('editModal').classList.add('active');
            document.getElementById('editForm').action = `/admin/rooms/${id}`;
            
            // Fill form with room data
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_capacity').value = capacity;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_description').value = description || '';
            
            console.log('Form status value set to:', document.getElementById('edit_status').value);
            
            // Handle image preview
            const currentImageContainer = document.getElementById('currentImageContainer');
            if (image && image !== 'null' && image !== '') {
                currentImageContainer.innerHTML = `
                    <div style="font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Foto saat ini:</div>
                    <div style="position: relative; display: inline-block;">
                        <img src="{{ asset('storage/') }}/${image}?v=${Date.now()}" alt="Current" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <button type="button" onclick="removeCurrentImage()" style="position: absolute; top: -8px; right: -8px; background: #dc2626; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; font-size: 12px; cursor: pointer;">×</button>
                    </div>
                `;
            } else {
                currentImageContainer.innerHTML = '';
            }
            
            document.getElementById('editPreview').style.display = 'none';
            document.getElementById('remove_image').value = '0';
            document.body.style.overflow = 'hidden';
        }

        // ⚡ CUSTOM FORM SUBMIT HANDLER
        function handleEditSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('editForm');
            console.log('Submitting form to:', form.action);
            console.log('Form data:', {
                name: form.edit_name.value,
                status: form.edit_status.value,
                code: form.edit_code.value,
                capacity: form.edit_capacity.value
            });
            
            // Submit form normally
            form.submit();
        }

        function removeCurrentImage() {
            document.getElementById('currentImageContainer').innerHTML = '';
            document.getElementById('remove_image').value = '1';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            document.getElementById('currentImageContainer').innerHTML = '';
            document.getElementById('remove_image').value = '0';
            document.body.style.overflow = 'auto';
        }

        let roomIdToDelete = null;
        let roomNameToDelete = null;

        function openDeleteModal(id, name) {
            roomIdToDelete = id;
            roomNameToDelete = name;
            document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus ruangan "${name}"? Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('deleteForm').action = `/admin/rooms/${id}`;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Image preview function
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const previewImage = document.getElementById(previewId === 'addPreview' ? 'addPreviewImage' : 'editPreviewImage');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove image function
        function removeImage(inputId, previewId) {
            document.getElementById(inputId).value = '';
            document.getElementById(previewId).style.display = 'none';
            if (previewId === 'editPreview') {
                document.getElementById('remove_image').value = '1';
            }
        }

        // File upload hover effect
        document.querySelectorAll('.file-upload').forEach(upload => {
            upload.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--brand)';
                this.style.background = '#f0f9ff';
            });
            
            upload.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#cbd5e1';
                this.style.background = 'transparent';
            });
            
            upload.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#cbd5e1';
                this.style.background = 'transparent';
                
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const input = this.querySelector('input[type="file"]');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
        });

        // User dropdown
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

        // Close modals on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
                closeDeleteModal();
            }
        });

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    if (modal.id === 'addModal') closeAddModal();
                    if (modal.id === 'editModal') closeEditModal();
                    if (modal.id === 'deleteModal') closeDeleteModal();
                }
            });
        });

        // ⚡ BROWSER BACK/FORWARD DETECTION
        window.onpageshow = function(event) {
            if (event.persisted) {
                console.log('Page loaded from cache, forcing refresh...');
                forceRefresh();
            }
        };

        console.log('Rooms management page initialized at:', new Date().toLocaleTimeString());
    </script>

</body>
</html>