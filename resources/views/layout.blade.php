<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>CRUD- @yield('title')</title>
</head>
<body>

<div class="container">
    @yield('content')
</div>
@yield('css')
@yield('js')
</body>
</html>