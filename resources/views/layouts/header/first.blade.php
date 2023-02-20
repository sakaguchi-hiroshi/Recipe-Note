@section('header')
  <section class="header-section">
    <div class="user-navi">
      <a href="{{ url('/services/premium')}}" class="ps-link">プレミアムサービス</a>
      @guest
      <a href="/register" class="register-link">会員登録</a>
      <a href="/login" class="login-link">ログイン</a>
      @endguest
      @auth
      <a href="/logout" class="logout-link">ログアウト</a>
      @can('manager_only')
      <a href="{{ route('managements.manage')}}" class="manage-link">管理者画面</a>
      @endcan
      @endauth
    </div>
  </section>
@endsection