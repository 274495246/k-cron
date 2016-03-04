<?php
/**
 * server.php.
 * Author: yeweijian
 * E-mail: yeweijian@hoolai.com
 * Date: 2016/2/16
 * Time: 10:55
 */
use EasyWork\Cron\Process;
use EasyWork\Cron\Worker;
use EasyWork\DI;


$di = DI::factory();

$di->setShare('__sys_process', function () {
    return new Process();
});

$di->setShare('__sys_worker', function () {
    return new Worker();
});

return $di;