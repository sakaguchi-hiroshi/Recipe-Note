<?php
namespace app\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RankingService
{
    protected $redis;

    public function __construct()
    {
        $this->redis = Redis::connection();
        $this->redis->connect('recipe-note-cluster.gfg0pn.clustercfg.apne1.cache.amazonaws.com:6379', 6379);
    }

    public function incrementViewRanking($id)
    {
        $key = "ranking-"."id:".$id;
        $value = $this->redis->get($key);

        if(empty($value)) {
            $this->redis->set($key, "1");
            $this->redis->expire($key, 3600 * 24);
        } else {
            $this->redis->set($key, $value + 1);
        }
    }

    public function getRankingAll()
    {
        $keys = $this->redis->keys('ranking-*');
        $results = Array();

        if(!empty($keys)) {
            for($i = 0; $i < sizeof($keys); $i++) {
                $id = explode(':', $keys[$i])[1];
                $point = $this->redis->get('ranking-id:'.$id);
                $results[$id] = $point;
            }
            arsort($results, SORT_NUMERIC);
        }
        return $results;
    }
}

