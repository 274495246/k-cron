<?php
/**
 * ReadBookWorker.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 15:49
 */

namespace App\Workers;

use EasyCron\EasyDB;
use EasyCron\Log;
use App\Models\DataDealModel;
use EasyCron\DB;

class PaymentWorker extends Base
{
    private $db;
    private $table = 'st_payment_detail';

    public function __construct()
    {   //同步 mysql
        $this->db = DB::instance('_back', false);
                
    }     
    /**
     * 运行入口
     * @param $task
     * @return mixed
     */
    public function run($data)
    {
        $data = json_decode($data,true);

        $rs = $this->db->insert($this->table,$data);

        //写入日志  
        log::async_file($data,'payment/payment');
        echo 'add ok!';
        if(!$rs){
            $rs = $this->db->insert($this->table,$data);
            //写入日志  
            log::async_file($data,'payment/payment');
            if(!$rs){
                //写入日志
                $data['ERROR'] = '写入失败';
                log::async_file($data,'payment/payment');                    
                echo "ERR...";$this->_exit();
            }
        }                               

        if ($data == 'exit') {
            $this->_exit();
        }  
    }


   
}