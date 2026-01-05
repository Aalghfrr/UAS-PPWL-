<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MeetSpace') - MeetSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @if(Auth::check() && Auth::user()->isAdmin())
        @include('layouts.admin-header')
    @elseif(Auth::check() && Auth::user()->isUser())
        @include('layouts.user-header')
    @endif
    
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>