@extends('layouts.app')
  @section('title', 'プレミアムサービス')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/recipenotes/service.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
    <section class="main-section">
      <h2 class="section-headline">プレミアムサービス</h2>
      <div class="regist-btn">
        <form action="{{ asset('pay') }}" method="POST">
            {{ csrf_field() }}
          <script
              src="https://checkout.stripe.com/checkout.js" class="stripe-button"
              data-key="{{ env('STRIPE_KEY') }}"
              data-amount="200"
              data-name="Stripe決済デモ"
              data-label="登録をする"
              data-description="これはデモ決済です"
              data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
              data-locale="auto"
              data-currency="JPY">
          </script>
        </form>
      </div>
      <div class="features">
        <h3 class="features-headline">プレミアムサービスでできること</h3>
        <div class="features-row">
          <div class="feature-column-2">
            <h4 class="feature-column-headline">人気のレシピがすぐ見つかる！</h4>
            <p class="feature-column-text">「人気順ランキング」や「レシピアクセス数ランキング」で美味しいレシピやみんなのおすすめレシピがすぐに見つかる！自慢の料理のレパートリーが増えより一層料理が楽しくなる！</p>
          </div>
          <div class="feature-column-2">
            <h4 class="feature-column-headline">1000件のレシピが保存可能に！</h4>
            <p class="feature-column-text">お気に入りのレシピを保存できる件数が1000件に容量アップ。気になるレシピを容量を気にせず、どんどん保存が可能に！</p>
          </div>
        </div>
        <table class="features-table">
          <tr class="table-row-4">
            <th class="table-headline"></th>
            <th class="table-headline">無料会員</th>
            <th class="table-headline">プレミアム会員</th>
          </tr>
          <tr class="table-row-4">
            <th class="table-headline">大人気レシピがわかる「人気順ランキング」</th>
            <td class="free">✖️</td>
            <td class="ps">◯</td>
          </tr>
          <tr class="table-row-4">
            <th class="table-headline">マイレシピにお気に入り保存</th>
            <td class="free">20件まで</td>
            <td class="ps">1000件まで</td>
          </tr>
          <tr class="table-row-4">
            <th class="table-headline">人気レシピアクセス数ランキング</th>
            <td class="free">✖️</td>
            <td class="ps">◯</td>
          </tr>
        </table>
      </div>
    </section>
  @endsection

  @include('layouts.footer.first')