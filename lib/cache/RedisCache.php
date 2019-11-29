<?php
namespace wechat\lib\cache;

use wechat\lib\Config;


class RedisCache implements ICacheMethod
{

    public function cache($key, $value=false, $timeout=7000)
    {
        // TODO: Implement cache() method.

        if ($value){
            $redis = $this->redis();
            $redis -> set($key,$value);
            $redis -> expire($key,$timeout);
            $redis = null;
            return true;
        }else{
            $redis = $this->redis();
            $str = $redis -> get($key);
            $redis = null;
            return $str;
        }
    }

    private function redis(){
        $config = Config::redis();
        $redis = new \Redis();
        $redis->connect($config['host'],$config['port']);
        $redis->auth($config['auth']);
        $redis->select($config['dbIndex']);
        return $redis;
    }

}