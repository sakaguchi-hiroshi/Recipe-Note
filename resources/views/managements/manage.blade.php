<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('/assets/css/index.css')}}">
  <title>management</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="header-left">
        <h1><a href="/" class="header-title">Recipe Note</a></h1>
      </div>
      <div class="header-right">
        <div class="header-navi">
          <ul class="navi-list">
            <li><a href="#" id="indicate-btn" class="indicate-btn" data-indicate-content="user">ユーザー一覧を表示する</a></li>
            <li><a href="#" id="indicate-btn" class="indicate-btn" data-indicate-content="post">投稿レシピ一覧を表示する</a></li>
          </ul>
        </div>
      </div>
    </header>
    <main class="main">
      <div class="result"></div>
    </main>
    <footer class="footer">
      <small class="copyright">Copyright© RecipeNote Inc.</small>
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{ mix('js/index.js') }}"></script>
  <script src="{{ mix('js/manage.js') }}"></script>
</body>
</html>