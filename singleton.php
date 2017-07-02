<?php

class Singleton {
    private static $instances = array();

	/**
     * Make constructor private, so nobody can call "new Class".
     */
	private function __construct() {

    }
	/**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {

    }
    
    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {

    }
    
    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
    */    
    private function __wakeup() {
    	
    }

    public static function getInstance() {
        $cls = get_called_class(); // late-static-bound class name
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }
}