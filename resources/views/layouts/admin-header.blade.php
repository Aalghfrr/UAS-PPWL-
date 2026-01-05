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
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item logout" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</header>

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