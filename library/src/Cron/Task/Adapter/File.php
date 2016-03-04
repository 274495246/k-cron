<?php
/**
 * File.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:16
 */

namespace EasyWork\Cron\Task\Adapter;


use EasyWork\Loader;
use EasyWork\Log;

class File
{
    protected $filePath;
    protected $oriTasks;

    public function __construct($file)
    {
        if(empty($file) || (!empty($file) && !file_exists($file))){
            Log::log_write("指定配置文件不存在,file:".$file);
            exit;
        }
        $this->filePath = $file;
    }

    /**
     * 返回格式化好的任务配置
     * @return array
     */
    public function getTasks()
    {
        $this->loadTasks();
        return self::parseTasks();
    }

    public function reloadTasks()
    {
        $this->loadTasks();
        $this->config = $this->parseTasks();
    }

    /**
     * 从配置文件载入配置
     */
    protected function loadTasks()
    {
        $this->oriTasks = Loader::import($this->filePath);
    }

    /**
     * 格式化配置文件中的配置
     * @return array
     */
    protected function parseTasks()
    {
        $tasks = array();
        if (is_array($this->oriTasks)) {
            foreach ($this->oriTasks as $key => $val) {
                $tasks[$key] = array(
                    "taskname" => $val["taskname"],
                    "rule" => $val["rule"],
                    "unique" => $val["unique"],
                    "execute" => $val["execute"],
                    "args" => $val["args"]
                );
            }
        }
        return $tasks;
    }
}