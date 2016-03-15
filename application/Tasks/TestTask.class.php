<?php
/**
 * TestTask.class.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/19
 * Time: 15:33
 */

namespace App\Tasks;


use EasyCron\Async\Coroutine\EndTask;
use EasyCron\DB;
use EasyCron\Sync;
use EasyCron\Redis;
use EasyCron\Log;

class TestTask
{

    /**
     * 异步任务处理
     * @param $worker
     * @param $a
     * @return \Generator
     */
    public function runAsync($worker, $a)
    {
        // echo $a, time(), PHP_EOL;
        // $db = DB::instance('_back');
        // $data = (yield $db->queryOne('select * from st_loading '));
        // echo var_export($data, true), PHP_EOL;
        // yield new EndTask($worker);
    }

    /**
     * 同步任务处理
     * @param $worker
     * @param $a
     */
    public function runSync($worker, $a)
    {
//异步redis
         // $redis = Redis::instance('_redis_back');
         // yield $redis->hset('gggg','aaa',1);
         // $a = ( yield $redis->hgetall('gggg'));
         // print_r( $a);
         // exit;
        //同步redis
         $redis = Redis::instance('_redis_back',false);
          $redis->hset('aagggg','aaa',1);
         $a = $redis->hgetall('aagggg');
         print_r( $a);
         exit;
 exit;
        echo $a, time();
        $db = DB::instance('_actor', false);
        $data = $db->queryOne('select * from actors limit 1');
        //echo var_export($data, true), PHP_EOL;
        $file_path = ROOT_PATH . "logs/test2.log";
        echo $file_path;
        $file_content = 'aaaaaaaaaaaaaass222222';
        swoole_async_writefile($file_path, $file_content);
        $worker->close();
        return;
    }
    //crontab 时间格式测试
    public function test($worker, $a){
                      //写入日志  
echo $a;
            log::async_file($a,'payment/payment'); 
        //              $file_path = ROOT_PATH . "logs/test2.log";
        // echo $file_path;
        // $file_content = 'aaaaaaaaaaaaaass222222';
        // swoole_async_writefile($file_path, $file_content);
        $worker->close();
        return;
    } 

}