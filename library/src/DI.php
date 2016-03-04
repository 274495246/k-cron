<?php
/**
 * DI.php .
 * Author: yexiaojian
 * E-mail: yeweijian188@163.com
 * Date: 16/1/17
 * Time: 00:23
 */

namespace EasyWork;


use EasyWork\DI\DIException;
use EasyWork\DI\Injection;

final class DI implements \ArrayAccess
{

    /**
     * 对象池
     * @var array
     */
    protected $_di = [];

    /**
     * DI实例
     * @var DI
     */
    protected static $_instance = null;

    protected function __construct()
    {

    }

    /**
     * 单例方法
     * @return DI
     */
    public static function factory()
    {
        if (!is_object(static::$_instance)) {
            static::$_instance = new static;
        }
        return static::$_instance;
    }

    /**
     * 设置对象
     * @param string $name                 对象标识
     * @param mixed $value                 对象参数
     * @param bool|false $isShare   是否共享
     * @return $this|bool
     */
    public function set($name, $value, $isShare = false)
    {
        if (empty($name) || empty($value)) return false;
        $this->_di[$name] = [
            'options' => $value,
            'isShare' => boolval($isShare)
        ];
        return $this;
    }

    /**
     * 获取对象池中的对象
     * @param string $name
     * @return mixed|null|object
     * @throws DIException
     */
    public function get($name)
    {
        if (!isset($this->_di[$name])) return null;

        if (isset($this->_di[$name]['object']) && $this->_di[$name]['isShare']) {
            return $this->_di[$name]['object'];
        }

        $options = $this->_di[$name]['options'];
        //判断是否为闭包
        if ($options instanceof \Closure) {
            $obj = call_user_func($options);
        } else {
            $type = gettype($options);
            $className = $params = null;
            switch ($type) {
                case 'array':
                    if (!isset($options['className'])) {
                        throw new DIException('[className] is not empty!');
                    }
                    $className = $options['className'];
                    $params = isset($options['params']) ? $options['params'] : [];

                case 'string':
                    $className = $className ?: $options;
                    if (!class_exists($className)) {
                        throw new DIException("[{$className}] is not exist!");
                    }
                    $re_args = array();
                    $refClass = new \ReflectionClass($className);
                    if (false == $refClass->getConstructor()->isPublic()) {
                        throw new DIException('error');
                    }
                    if (count($params) > 0) {
                        $refMethod = new \ReflectionMethod($className, '__construct');
                        $args = $refMethod->getParameters();

                        foreach ($args as $key => $param) {
                            if ($param->isPassedByReference()) {
                                $re_args[$key] = &$params[$key];
                            } else {
                                $re_args[$key] = $params[$key];
                            }
                        }
                    }

                    $obj = $refClass->newInstanceArgs((array)$re_args);
                    break;
                default:
                    $obj = $options;
            }
        }
        //DI依赖注入
        if (is_object($obj) && $obj instanceof Injection) {
            $obj->setDI($this);
        }
        //保存对象
        if ($this->_di[$name]['isShare']) {
            $this->_di[$name]['object'] = $obj;
        }
        return $obj;
    }

    /**
     * 设置共享对象
     * @param $name
     * @param $value
     * @return $this|bool|DI
     */
    public function setShare($name, $value)
    {
        return $this->set($name, $value, true);
    }

    /**
     * 判断对象是否存在
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->_di[$name]);
    }

    /**
     * 删除对象
     * @param $name
     */
    public function del($name)
    {
        unset($this->_di[$name]);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->_di[$name]['object'] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->_di[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->_di[$offset]['object'] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_di[$offset]);
    }

    protected function __clone()
    {

    }
}