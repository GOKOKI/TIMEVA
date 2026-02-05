<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="font-sans">
    @include('layout.partials.prohead')

    <main>
        @yield('content')
    </main>

    @include('layout.partials.footer')
</body>