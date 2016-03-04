<?php
/**
 * TaskRerunWorker.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/17
 * Time: 15:39
 */

namespace App\Worker;


use EasyWork\Log;

/**
 * Class TaskRerunWorker
 * @package EasyWork\Cron\Worker
 */
class TaskRerunWorker extends Base
{

    /**
     * 运行入口
     * @param $task
     * @return mixed
     */
    public function run($task)
    {
        //echo __FILE__.$task;
        //$task = json_decode($task, true);
    }
}