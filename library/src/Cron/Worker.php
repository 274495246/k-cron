<?php
/**
 * Worker.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:25
 */

namespace EasyWork\Cron;


//use EasyWork\Cron\Worker\Base;
use App\Worker\Base;
use EasyWork\Loader;
use EasyWork\Log;

class Worker
{
    public $workers;

    public function loadWorker()
    {
        foreach ($this->getWorkers() as $classname => $task) {
            for ($i = 1; $i <= $task["processNum"]; $i++) {
                $this->create_process($classname, $i, $task["redis"]);
            }
        }
    }

    protected function getWorkers()
    {
        $config = Loader::import(CRON_CONF_PATH . "/worker.php");
        if (empty($config)) {
            return array();
        }
        return $config;
    }

    /**
     * 创建一个子进程
     * @param $classname
     * @param $number
     * @param $redis
     */
    public function create_process($classname, $number, $redis)
    {
        $this->workers["classname"] = $classname;
        $this->workers["number"] = $number;
        $this->workers["redis"] = $redis;
        $process = new \swoole_process(array($this, "run"));
        if (!($pid = $process->start())) {

        }
        //记录当前任务
        Crontab::$task_list[$pid] = array(
            "start" => microtime(true),
            "classname" => $classname,
            "number" => $number,
            "redis" => $redis,
            "type" => "worker",
            "process" => $process
        );
    }

    /**
     * 子进程执行的入口
     * @param \swoole_process $worker
     */
    public function run($worker)
    {
        $class = $this->workers["classname"];
        $number = $this->workers["number"];
        $worker->name("lzm_worker_" . $class . "_" . $number);
//        $class = __NAMESPACE__ . '\Worker\\' .$class . "Worker";
        if (!class_exists($class)) {
            Log::log_write("处理类{$class}不存在");
            $worker->exit(1);
            return;
        }

        /** @var \EasyWork\Cron\Worker\Base $w */
        /*App\Worker*/
        $w = new $class;

        if (!($w instanceof Base)) {
            Log::log_write("处理类{$class}没有继承EasyWork\\Cron\\Worker\\Base");
            $worker->exit(1);
            return;
        }

        $w->content($this->workers["redis"]);
        $w->tick($worker);
    }
}