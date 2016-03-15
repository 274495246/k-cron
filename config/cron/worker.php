<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 15-11-3
 * Time: 下午10:10
 */


return array(
    //key是要加载的worker类名
    App\Worker\LoadingWorker::class => [
        "name" => "loading",            //备注名
        "processNum" => 1,           //启动的进程数量
        "redis" => [
            "host" => "127.0.0.1",    // redis ip
            "port" => 6379,           // redis端口
            "timeout" => 30,          // 链接超时时间
            "db" => 0,                // redis的db号
            "queue" => "report:load",         // redis队列名
            "limit" =>  400,          // 每次执行出队列的阀值
            "param_list" =>  "logdate|pf|account|counter|kingdom|is_new|exts|serverid"         // 数据库的字段对应 解析数据 a|b|c|d 参数
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