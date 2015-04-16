<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/16
 * Time: 18:16
 */

namespace Yaf;


final class Session implements \Countable,\Iterator,\ArrayAccess {

    protected static $_instance = null;
    protected $_session = null;
    protected $_started = false;

    private function __construct()
    {

    }

    public function start()
    {
        if($this->_started)
            return $this;

        session_start();
        $this->_started = true;

        return $this;
    }

    public static function getInstance()
    {
        if(!is_object(self::$_instance) || !( self::$_instance instanceof Session) )
        {
            $instance = new Session();
            $instance->start();
            $instance->_session = $_SESSION;

            self::$_instance = $instance;
        }

        return self::$_instance;
    }

    // implement iterator
    public function current()
    {
        return current($this->_session);
    }

    public function next()
    {
        next($this->_session);
    }

    public function key()
    {
        return key($this->_session);
    }

    public function valid()
    {
        if(key($this->_session) !== null)
            return true;
        return false;
    }

    public function rewind()
    {
        rewind($this->_session);
    }

    // implement array access
    public function offsetExists($offset)
    {
        return array_key_exists($offset,$this->_session);
    }

    public function offsetGet($offset)
    {
        return $this->_session[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->_session[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_session[$offset]);
    }

    public function count()
    {
        return count($this->_session);
    }


    // other interface
    public function has($name)
    {
        return array_key_exists($name,$this->_session);
    }

    public function get($name)
    {
        if($name == "")
            return $this->_session;

        if(array_key_exists($name,$this->_session))
           return $this->_session[$name];

        return null;
    }

    public function set($name,$value)
    {
        $this->_session[$name] = $value;
        return $this;
    }

    public function clear()
    {
        $this->_session = array();
    }

    public function del($name)
    {
        unset($this->_session[$name]);
        return $this;
    }
}