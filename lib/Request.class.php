<?php
class Request {
    private $_http = null; 

    public function __construct() {   
        $request_type = defined("REQUEST_TYPE")? constant("REQUEST_TYPE") : "snoopy"; 
        include_once(ROOT_DIR."lib/request/".$request_type.".php");
        $class = "request_".$request_type;
        $this->_request = new $class();
        if(!($this->_request instanceof request_interface)) throw new Exception("not implements request_interface interface");
    }

    public function submit($url,$aParams,$aHeader = array()) {
        return $this->_request->submit($url,$aParams,$aHeader);
    }

    public function getResult() {
        return $this->_request->getResult();
    }

} // end class
