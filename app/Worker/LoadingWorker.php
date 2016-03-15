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
use EasyWork\Log;



class LoadingWorker extends Base
{

    /**
     * 运行入口
     * @param $task
     * @return mixed
     */
    public function run($task)
    {
        $data = $this->param_parse($task);
        $db = new EasyDB('test_123');
        $rs = $db->insert('log_loading_20160307', $data);
        // // $where = ['name'=>'lisx8'];
        // // $del = $db->delete('user', $where);
        echo 'rs:'.$rs."\n";
        if(!$rs){
            $rs = $db->insert('log_loading_20160307', json_decode($task, true));
            if(!$rs){
                echo "ERR...";$this->_exit();
            }
        }
        if ($task == 'exit') {
            $this->_exit();
        }
    }
}