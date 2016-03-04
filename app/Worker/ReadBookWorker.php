<?php
/**
 * ReadBookWorker.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 15:49
 */

namespace App\Worker;

use EasyWork\EasyDB;



class ReadBookWorker extends Base
{

    /**
     * 运行入口
     * @param $task
     * @return mixed
     */
    public function run($task)
    {
        //echo __FILE__.$task . "\n";
        $db = new EasyDB('test_123');
        $rs = $db->insert('user', json_decode($task, true));   
        $where = ['name'=>'lisx8'];
        $del = $db->delete('user', $where);
        echo 'del:'.$del."\n";
        if ($task == 'exit') {
            $this->_exit();
        }
    }
}