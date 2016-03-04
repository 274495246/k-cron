<?php
/**
 * PaymentModel.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/16
 * Time: 17:23
 */

namespace App\Models;


use EasyWork\EasyDB;

class PaymentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new EasyDB('test_123');
    }

    public function fetchAll()
    {
        return $this->db->queryAll('select * from user limit 0,1000');
    }

}