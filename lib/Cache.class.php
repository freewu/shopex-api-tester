<?php
class Cache {
    private $_cache = null; 

    public function __construct($type) {   
        $cache_type = defined("CACHE_TYPE")? constant("CACHE_TYPE") : "filesystem"; 
        include_once(ROOT_DIR."lib/cache/".$cache_type.".php");
        $class = "cache_".$cache_type;
        $this->_cache = new $class($type);
        //call_user_func(array("cache_".$cache_type,"__construct"),$type);
        if(!($this->_cache instanceof cache_interface)) throw new Exception("not implements cache_interface interface");
    }
    
    public function getList() {
        return $this->_cache->getList();
    }
    
    public function getData($url,$act = null) {
        return $this->_cache->getData($url,$act);
    }
    
    public function saveData($aSystem,$aData) {
        return $this->_cache->saveData($aSystem,$aData);
    }

} // end class
