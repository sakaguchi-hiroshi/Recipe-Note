<?php
namespace app\Services;

use Illuminate\Http\Request;
use Redis;

class RankingService
{

  public function incrementViewRanking($id)
  {
    $key = "ranking-"."id:".$id;
    $value = Redis::get($key);

    if(empty($value)) {
      Redis::set($key, "1");
      Redis::expire($key, 3600 * 24);
    } else {
      Redis::set($key, $value + 1);
    }
  }

  public function getRankingAll()
  {
    $keys = Redis::keys('ranking-*');
    $results = Array();

    if(!empty($keys)) {
      for($i = 0; $i < sizeof($keys); $i++) {
        $id = explode(':', $keys[$i])[1];
        $point = Redis::get('ranking-id:'.$id);
        $results[$id] = $point;
      }
      arsort($results, SORT_NUMERIC);
    }
    return $results;
  }
}