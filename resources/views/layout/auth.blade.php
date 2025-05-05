<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.head')
    @include('layout.css')
    <title>@yield('title', 'Login')</title>
</head>
<body>
    <main>
        @yield('content')
    </main>

    @include('layout.script')
</body>
</html>
