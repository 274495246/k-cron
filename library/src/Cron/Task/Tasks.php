<?php
/**
 * Tasks.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:15
 */

namespace EasyWork\Cron\Task;


use EasyWork\Cron\Task\Adapter\File;
use EasyWork\Cron\Task\Adapter\Mysql;

class Tasks
{
    private $handle;

    public function __construct($type, $params = "")
    {
        switch ($type) {
            case "file":
                $this->handle = new File($params);
                break;
            case "mysql":
                $this->handle = new Mysql($params);
                break;
            default:
                $this->handle = new File($params);
                break;
        }
    }

    /**
     * 获取需要执行的任务
     * @return array
     */
    public function getTasks()
    {
        return $this->handle->getTasks();
    }

    /**
     * 重载任务配置
     */
    public function reloadTasks()
    {
        $this->handle->reloadTasks();
    }
}