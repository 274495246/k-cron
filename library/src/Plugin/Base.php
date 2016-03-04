<?php
/**
 * Plugin.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 11:27
 */

namespace EasyWork\Plugin;




abstract class Base
{
    /**
     * @var \swoole_process
     */
    public $worker;


    public function delay($sec)
    {
        if (!is_numeric($sec)) {
            return false;
        }
        $task = $this->worker->pid . "," . $sec;
        $this->worker->write($task);
        if ($this->worker->read() == $task) {
            return true;
        }
        return false;
    }

    abstract public function run($task);

}