<?php
class Cache {
    var $_dir = null;
    var $_type = null;
    
    function Cache($type) {   
        $this->_type = $type;
        $this->_dir = dirname(__FILE__)."/../data/".$type."/";
        if(!is_dir($this->_dir)) {
            chdir("data");
            mkdir($type,0775);
        }
    }
    
    function getList() {
        return $this->_getList();
    }
    
    function _getList() {
        $oDir = opendir($this->_dir);
        $aResult = array();
        while($item = readdir($oDir))
        {
            $aTemp = pathinfo($item);
            if(isset($aTemp['extension']) && $aTemp['extension']=='php')
            {
                $content= @file_get_contents($this->_dir.$item);
                if($content)
                {
                    $content = @unserialize($content);
                    if($content)
                    {
                        $aResult[] = $content;
                    }
                }
            }
        }
        return $aResult;
    }
    
    function getData($url,$act = null) {
        $file = $this->_dir."/".md5($url).".php";
        if(!file_exists($file)) return false;
        $content = @file_get_contents($file);
        if(empty($content)) return false;
        $content = @unserialize($content);
        if($act && isset($content['data'][$act])) return $content['data'][$act];
        return $content;
    }
    
    function saveData($aSystem,$aData)
    {
        if(!isset($aSystem['url']) || empty($aSystem['url']) || empty($aData[METHOD])) return false;
        $aResult = $this->getData($aSystem['url']);
        $aResult['url'] = $aSystem['url'];
        $aResult['token'] = $aSystem['token'];
        $aResult['data'][$aData[METHOD]] = $aData;
        
        $file = $this->_dir.md5($aSystem['url']).".php";
        return file_put_contents($file,serialize($aResult));
    }
}
?>