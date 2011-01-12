<?php
class Cache
{
    var $_dir = null;
    var $_type = null;
    
    function Cache($type)
    {   $this->_type = $type;
        $this->_dir = dirname(__FILE__)."/../data/".$type."/";
        if(!is_dir($this->_dir)) {
            chdir("data");
            mkdir($type,0775);
        }
    }
    
    function getList()
    {
        return $this->_getList();
    }
    
    function _getList()
    {
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
    
    function getData($url)
    {
        $file = $this->_dir.$this->_type."/".md5($url).".php";
        if(!file_exists($file)) return false;
        $content = @file_get_contents($file);
        if(empty($content)) return false;
        $content = @unserialize($content);
        return $content;
    }
    
    function saveData($aData)
    {
        $aResult = array();
        if(isset($aData['url'])) $aResult = $this->getData($aData['url']);
        $aResult['url'] = $aData['url'];
        unset($aData['url']);
        if(isset($aData[ACNAME])) unset($aData[ACNAME]);
        $act = isset($aData['act'])? $aData['act'] : $aData['method'];
        if(empty($act)) return false;
        $aResult['data'][$act] = $aData;
        
        $file = $this->_dir.md5($aData['url']).".php";
        return file_put_contents($file,serialize($aResult));
    }
}
?>