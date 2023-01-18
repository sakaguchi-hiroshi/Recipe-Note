@extends('layouts.service')
  @section('title', 'プレミアムサービスの内容')
  @section('header')
  <h1 class="header_title"><a href="/" class="home">Recipe Note</a></h1>
  <div class="header_ps_register">
    <a href="" class="ps_register_link">登録する</a>
  </div>
  <ul class="link_list">
    <li>
      <a href="">できること</a>
    </li>
    <li>
      <a href="">機能比較表</a>
    </li>
  </ul>
  @endsection
  @section('main')
  <section class="contents">
    <div class="box">
      <div class="main_form">
        <h2 class="main_form_title">プレミアムサービス</h2>
        <div class="main_form_ps_register">
          <a href="" class="ps_register_link">登録する</a>
        </div>
      </div>
      <div class="ps_features">
        <h3 class="ps_features_heading">プレミアムサービスでできること</h3>
        <div class="ps_features_row">
          <div class="ps_features_column">
            <h4 class="ps_features_subheading">人気のレシピがすぐ見つかる！</h4>
            <p class="ps_features_paragraph">「人気順検索」や「レシピアクセス数ランキング」で美味しいレシピやみんなのおすすめレシピがすぐに見つかる！自慢の料理のレパートリーが増えより一層料理が楽しくなる！</p>
          </div>
          <div class="ps_features_column">
            <h4 class="ps_features_subheading">1000件のレシピが保存可能に！</h4>
            <p class="ps_features_paragraph">お気に入りのレシピを保存できる件数が1000件に容量アップ。気になるレシピを容量を気にせず、どんどん保存が可能に！</p>
          </div>
        </div>
      </div>
      <div class="ps_features_table">
        <table class="table_basic">
          <tr>
            <th class="title"></th>
            <th class="free_user">無料会員</th>
            <th class="ps_user">プレミアム会員</th>
          </tr>
          <tr>
            <th class="title">大人気レシピがわかる「人気順検索」</th>
            <td class="free">✖️</td>
            <td class="ps">◯</td>
          </tr>
          <tr>
            <th class="title">マイレシピにお気に入り保存</th>
            <td class="free">20件まで</td>
            <td class="ps">1000件まで</td>
          </tr>
          <tr>
            <th class="title">人気レシピアクセス数ランキング</th>
            <td class="free">✖️</td>
            <td class="ps">◯</td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  @endsection