<?php
include_once(ROOT_DIR."lib/request/Snoopy.class.php");
include_once(ROOT_DIR."lib/request/interface.php");
class request_snoopy implements request_interface {
    private $_snoopy = null;
    
    public function __construct() {   
        $this->_snoopy = new Snoopy();
    }

    public function submit($url,$aParams,$aHeader = array()) {
        return $this->_snoopy->submit($url,$aParams);
    }
    
    public function getResult() {
        return $this->_snoopy->results;
    } 

} // end class

