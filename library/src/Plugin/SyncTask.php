<?php
/**
 * Coroutine.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 14:19
 */

namespace EasyWork\Plugin;


use EasyWork\Log;

class SyncTask extends Base
{

    public function run($task)
    {
        try {
            if (empty($task['class'])
                || empty($task['func'])
                || !class_exists($task['class'])
            ) {
                throw new \Exception("[system error]");
            }

            $obj = new $task['class'];

            if (!is_callable([$obj, $task['func']])) {
                throw new \Exception("[error] {$task['func']} is not exists");
            }

            if (!isset($task['params'])) {
                $task['params'] = [];
            }
            call_user_func_array([$obj, $task['func']], (array)$task['params']);
        } catch (\Exception $e) {
            Log::log_write($e->getMessage());
            $this->worker->exit(1);
        }
        /** 异步执行不需要关闭进程 */
        $this->worker->exit(0);
    }
}

