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
        if(empty($data) || !$data){
            $this->_exit();
        }
        $db = new EasyDB('test_123');
        $table = 'log_loading_' . date("Ymd", strtotime($data['logdate']));
        $rs = $db->insert($table, $data);
        if(!$rs){
            $rs = $db->insert($table, $data);
            if(!$rs){
                Log::log_write("打点数据插入失败:". $task);
            }
        }
        if ($task == 'exit') {
            $this->_exit();
        }
    }
}