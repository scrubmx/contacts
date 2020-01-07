<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700,800&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="/images/favicon.png">
</head>
    <body class="font-sans bg-gray-200">
        <div id="app">
            @include('layouts._nav')

            <main class="container mx-auto py-5" role="main">
                @yield('content')
            </main>
        </div>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
