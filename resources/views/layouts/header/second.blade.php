@section('header_second')
  <section class="header-section-secondary">
    <h1 class="header-headline"><a class="home-link" href="/">Recipe Note</a></h1>
    <div class="search-box">
      <form class="search-form" action="{{ route('posts.post', ['value' => 'post'])}}" method="get">
        <input type="text" name="keyword" class="keyword">
        <button type="submit" class="search-btn">検索する</button>
      </form>
    </div>
    <div class="my-menu">
      <ul class="my-menu-list">
        <li class="my-menu-list-item"><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a></li>
        <li class="my-menu-list-item"><a href="{{ route('myrecipes.form')}}" class="wr_link">レシピを書く</a></li>
      </ul>
    </div>
  </section>
@endsection