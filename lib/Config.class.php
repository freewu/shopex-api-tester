<?php
include_once("Cache.class.php");
class Config {	
    public function __construct($type = null) {
        if(!$type) $type = $this->getDefualtType();
        $this->_cache = new Cache($type);
    }

    private $_types  = null; 
    public function getTypes() {
        if(!$this->_types)  {
            $this->_types = $this->_getTypes();
        }
        return $this->_types;
    } // end function getTypes
    
    private function _getTypes() {
        $oDir = opendir(ROOT_DIR."config");
        $aResult = array();
        while($item = readdir($oDir)) {
            if(substr($item,0,6) == "config") {
                $aTemp = explode(".",$item);
                if(isset($aTemp[1]) && !empty($aTemp[1]) && isset($aTemp[2])) $aResult[] = $aTemp[1];
            }
        }
        return $aResult;
    } // end function getTypes

    public function getDefualtType() {
        $types = $this->getTypes();
        $type = (isset($_COOKIE['type']) && $_COOKIE['type'])? $_COOKIE['type'] : "b2b"; // b2b为默认吧
        $type = in_array($type,$types)? $type : 'b2b';
        return $type;
    } // end function getDefualtType

    public function getHistory() {
        return $this->_cache->getList();
    } // end function getHistory

} // end class 
