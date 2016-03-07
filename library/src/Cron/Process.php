<?php
/**
 * Process.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:24
 */

namespace EasyWork\Cron;


use EasyWork\Plugin\Base;
use EasyWork\Log;

class Process
{
    public $task;


    /**
     * 创建一个子进程
     * @param $task
     */
    public function create_process($id, $task)
    {
        $this->task = $task;
        $process = new \swoole_process([$this, "run"]);
        $pid = $process->start();
        //记录当前任务
        Crontab::$task_list[$pid] = [
            "start" => microtime(true),
            "id" => $id,
            "task" => $task,
            "type" => "crontab",
            "process" => $process,
        ];
    }

    /**
     * 子进程执行的入口
     * @param \swoole_process $worker
     */
    public function run($worker)
    {
        if (empty($this->task["execute"])) {
            $this->task["execute"] = \EasyWork\Plugin\SyncTask::class;
        }
        $class = $this->task["execute"];
        $worker->name("lzm_crontab_" . $class . "_" . $this->task["id"]);

        if (!class_exists($class)) {
            Log::log_write("处理类{$class}不存在");
            $worker->exit(1);
            return;
        }
        /** @var \EasyWork\Plugin\Base $c */
        $c = new $class;
        if (!($c instanceof Base)) {
            Log::log_write("处理类{$class}没有继承\\EasyWork\\Plugin\\Base");
            $worker->exit(1);
            return;
        }
        $c->worker = $worker;
        $c->run($this->task["args"]);
    }
}