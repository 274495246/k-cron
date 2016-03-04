<?php
/**
 * WorkerBase.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:29
 */

namespace App\Worker;


use EasyWork\Log;

abstract class Base
{
    /**
     * @var \Redis
     */
    private $redis;
    private $queue;
    /**
     * @var \swoole_process
     */
    protected $worker;
    private $ppid = 0;

    public function content($config)
    {

        if (!isset($config["host"]) || !isset($config["port"]) || !isset($config["timeout"]) || !isset($config["queue"])) {
            Log::log_write(vsprintf(" host=%s,port=%s,timeout=%s,queue=%s", $config));
            exit;
        }

        $this->redis = new \Redis();
        if (!$this->redis->pconnect($config["host"], $config["port"], isset($config["timeout"]))) {
            Log::log_write(vsprintf("redis can't connect.host=%s,port=%s,timeout=%s", $config));
            exit;
        }
        if (isset($config["db"]) && is_numeric($config["db"])) {
            $this->redis->select($config["db"]);
        }
        $this->queue = $config["queue"];
    }

    public function getQueue()
    {
        return $this->redis->rpop($this->queue);
    }

    public function tick($worker)
    {
        $this->worker = $worker;
        // \swoole_timer_tick(5000, function () {
        \swoole_timer_tick(5000, function () {
            //判断每次获取队列条数 
            $i = 1;
            $limit = $this->redis->llen($this->queue);
            if($limit > 10){
                $i = 10;
            }
            while ($i) {
                $this->checkExit();
                $task = $this->getQueue();
                if (empty($task)) {
                    break;
                }
                $this->run($task);
                $i--;
            }
            // while (true) {
            //     $this->checkExit();
            //     $task = $this->getQueue();
            //     if (empty($task)) {
            //         break;
            //     }
            //     $this->run($task);
            // }
        });
    }

    protected function _exit()
    {
        $this->worker->exit(1);
    }

    /**
     * 判断父进程是否结束
     */
    private function checkExit()
    {
        $ppid = posix_getppid();
        if ($this->ppid == 0) {
            $this->ppid = $ppid;
        }
        if ($this->ppid != $ppid) {
            $this->_exit();
        }
    }

    /**
     * 运行入口
     * @param $task
     * @return mixed
     */
    abstract public function run($task);
}