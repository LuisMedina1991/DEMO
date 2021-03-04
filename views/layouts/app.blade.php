<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('includes.head')
</head>

<body>
    <div id="app">

        @include('includes.header')
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
