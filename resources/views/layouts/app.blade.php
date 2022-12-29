<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('/assets/css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('/assets/css/index.css')}}">
</head>
<body>
  <header class="header">
    <div class="header_container">
      <div class="header_inner">
        <div class="user_navi">
          <a href="{{ url('/services/premium')}}" class="ps_link">プレミアムサービス</a>
          <a href="/register" class="register_link">会員登録</a>
          <a href="/login" class="login_link">ログイン</a>
        </div>
      </div>
    </div>
    <div class="header_container">
      <div class="header_inner">
        <h1 class="header_title"><a href="/" class="home">Recipe Note</a></h1>
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