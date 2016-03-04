<?php
return [
    'taskid1' =>
        [
            'taskname' => 'task1',  //任务名称
            'rule' => '1 */2 * * * *',//定时规则
            "unique" => 1, //排他数量，如果已经有这么多任务在执行，即使到了下一次执行时间，也不执行
            'execute' => '',//命令处理类（默认：EasyWork\Plugin\SyncTask::class）
            'args' =>
                [
                    'class' => App\Tasks\MainTask::class,//命令
                    'func' => 'test',//附加属性
                    'params' => []
                ],
        ],
    'taskid2' =>
        [
            'taskname' => 'task2',  //任务名称
            'rule' => '*/2 * * * * *',//定时规则
            "unique" => 1, //排他数量，如果已经有这么多任务在执行，即使到了下一次执行时间，也不执行
            'execute' => '',//命令处理类
            'args' =>
                [
                    'class' => App\Tasks\MainTask::class,//命令
                    'func' => 'test2',//附加属性
                    'params' => []
                ],
        ],
    // 'taskid3' =>
    //     [
    //         'taskname' => 'php -i',  //任务名称
    //         'rule' => '* * * * *',//定时规则
    //         "unique" => 1, //排他数量，如果已经有这么多任务在执行，即使到了下一次执行时间，也不执行
    //         'execute' => EasyWork\Cron\Plugin\Cmd::class,//命令处理类
    //         'args' =>
    //             [
    //                 'cmd' => 'php -i',//命令
    //                 'ext' => '',//附加属性
    //             ],
    //     ],
];
