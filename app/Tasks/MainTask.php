<?php
/**
 * MainTask.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/15
 * Time: 15:01
 */

namespace App\Tasks;


use App\Models\PaymentModel;
use EasyWork\DI;
use EasyWork\Log;

class MainTask
{
    public function test()
    {
        echo 'ok1',PHP_EOL;

//         $model = new PaymentModel();
        // $data = (yield $model->fetchAndAdd());
        // var_dump($data);
        // //if ($data['r'] == 0) Log::async_file($data['data']);
    }

    public function test2()
    {
        echo 'ok2', PHP_EOL;
    }
}