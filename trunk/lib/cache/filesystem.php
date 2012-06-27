<?php
include_once(ROOT_DIR."lib/cache/interface.php");
class cache_filesystem implements cache_interface {
    private $_dir = null;
    private $_type = null;
    
    public function __construct($type) {   
        $this->_type = $type;
        $this->_dir = ROOT_DIR."data/".$type."/";
        if(!is_dir($this->_dir)) {
            chdir(ROOT_DIR."data");
            mkdir($type,0775);
        }
    }
    
    function getList() {
        return $this->_getList();
    }
    
    function _getList() {
        $oDir = opendir($this->_dir);
        $aResult = array();
        while($item = readdir($oDir)) {
            $aTemp = pathinfo($item);
            if(isset($aTemp['extension']) && $aTemp['extension']=='php') {
                $content= @file_get_contents($this->_dir.$item);
                if($content) {
                    $content = @unserialize($content);
                    if($content) $aResult[] = $content;
                }
            }
        }
        return $aResult;
    }
    
    public function getData($url,$act = null) {
        $file = $this->_dir."/".md5($url).".php";
        if(!file_exists($file)) return false;
        $content = @file_get_contents($file);
        if(empty($content)) return false;
        $content = @unserialize($content);
        if($act && isset($content['data'][$act])) return $content['data'][$act];
        return $content;
    }
    
    public function saveData($aSystem,$aData) {
        if(!isset($aSystem['url']) || empty($aSystem['url']) || empty($aData[METHOD])) return false;
        $aResult = $this->getData($aSystem['url']);
        $aResult['url'] = $aSystem['url'];
        $aResult['token'] = $aSystem['token'];
        $aResult['data'][$aData[METHOD]] = $aData;
        
        $file = $this->_dir.md5($aSystem['url']).".php";
        return file_put_contents($file,serialize($aResult));
    }

} // end class

