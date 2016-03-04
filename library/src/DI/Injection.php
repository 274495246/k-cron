<?php
/**
 * Injection.php .
 * Author: yexiaojian
 * E-mail: yeweijian188@163.com
 * Date: 16/1/17
 * Time: 02:06
 */

namespace EasyWork\DI;


use EasyWork\DI;

interface Injection
{
    public function setDI(DI $di);

    public function getDI();
}