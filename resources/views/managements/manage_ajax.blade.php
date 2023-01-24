<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
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
        <tr>
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
        </tr>
        @foreach($items as $item)
        <tr>
          <td>{{ $item->user->name }}</td>
          <td>{{ $item->myrecipe__colection_id }}</td>
        </tr>
        @endforeach
      </table>
      @endif
    @endif
  </div>
</body>
</html>