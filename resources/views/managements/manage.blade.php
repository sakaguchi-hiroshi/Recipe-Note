<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/reset.css')}}">
  <link rel="stylesheet" href="{{ asset('/assets/css/index.css')}}">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{ mix('js/index.js') }}"></script>
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
            <li><a href="" id="indicate-btn" class="indicate-btn" data-indicate-content="user">ユーザー一覧を表示する</a></li>
            <li><a href="" id="indicate-btn" class="indicate-btn" data-indicate-content="post">投稿レシピ一覧を表示する</a></li>
          </ul>
        </div>
      </div>
    </header>
    <main class="main">
      <div class="main-content">
        @if(isset($indicateContent))
        @if($indicateContent == 'user')
        <div class="search-box">
          <form action="">
            <input type="text" class="search">
            <input type="submit" class="btn_submit">
          </form>
        </div>
        <table>
          <tr>
            <th>USER_ID</th>
            <th>権限名</th>
            <th>名前</th>
            <th>E-MAIL</th>
          </tr>
          @foreach($items as $item)
          <tr id="result">
            <td>{{ $item->id }}</td>
            <td>{{ $item->permission->name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
          </tr>
          @endforeach
        </table>
        @endif
        @if($indicateContent == 'post')
        <div class="search-box">
          <form action="">
            <input type="text" class="search">
            <input type="submit" class="btn_submit">
          </form>
        </div>
        <table>
          <tr>
            <th>投稿したユーザー名</th>
            <th>レシピのID</th>
            <th>レポートのID</th>
          </tr>
          @foreach($items as $item)
          <tr id="result">
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->myrecipe__colection_id }}</td>
            <td>{{ $item->reports->id}}</td>
          </tr>
          @endforeach
        </table>
        @endif
        @endif
      </div>
    </main>
    <footer class="footer">
      <small class="copyright">Copyright© RecipeNote Inc.</small>
    </footer>
  </div>
</body>
</html>