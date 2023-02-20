<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit=no>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/assets/css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('/assets/css/layout.css')}}">
  @yield('pageCss')
</head>
<body>
  <header class="header">
    @yield('header')
    @yield('header_second')
  </header>

  <main class="main">
    @yield('main')
  </main>

  <footer class="footer">
    @yield('footer')
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{ mix('js/index.js') }}"></script>
  <script src="https://kit.fontawesome.com/b8e0fd0230.js" crossorigin="anonymous"></script>
</body>
</html>