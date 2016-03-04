<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 15-11-3
 * Time: 下午10:10
 */


return array(
    //key是要加载的worker类名
    App\Worker\ReadBookWorker::class => [
        "name" => "queue1",            //备注名
        "processNum" => 1,           //启动的进程数量
        "redis" => [
            "host" => "127.0.0.1",    // redis ip
            "port" => 6379,           // redis端口
            "timeout" => 30,          // 链接超时时间
            "db" => 0,                // redis的db号
            "queue" => "reload1"          // redis队列名
        ]
    ],

    //key是要加载的worker类名
    App\Worker\TaskRerunWorker::class => [
        "name" => "queue2",            //备注名
        "processNum" => 1,           //启动的进程数量
        "redis" => [
            "host" => "127.0.0.1",    // redis ip
            "port" => 6379,           // redis端口
            "timeout" => 30,          // 链接超时时间
            "db" => 0,                // redis的db号
            "queue" => "reload"          // redis队列名
        ]
    ]
);