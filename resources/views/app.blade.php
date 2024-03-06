<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/assets/sass/vars.scss', 'resources/assets/sass/style.scss', 'resources/css/reset.css', 'resources/js/app.js'])
    @section('css')
        <!-- some master css here -->
    @show
</head>

<body>

    <div id="app">
        @section('navbar')
            @include('common.navbar')
        @show

        @yield('content')

        @include('common.footer')

        @section('js')
        @show
    </div>

  
</body>

</html>
