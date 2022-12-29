<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('/assets/css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('/assets/css/service.css')}}">
</head>
<body>
  <header class="header">
    <div class="header_container">
      <div class="header_inner">
        @yield('header')
      </div>
    </div>
  </header>
  <main class="main">
    @yield('main')
  </main>
  <footer class="footer">
    <small class="copyright">Copyright© RecipeNote Inc.</small>
  </footer>
</body>
</html>