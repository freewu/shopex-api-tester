<?php
include_once("Snoopy.class.php");
include_once("Cache.class.php");
class Process
{
    var $_post = null;
    var $_required = null;
    var $_url = null;
    var $_token = null;
    var $_cache = null;
    var $_result = null;

    function Process($required = array()){
        $this->_cache = new Cache(APITYPE);
        $aData = $this->run($required);
        // 保存数据
        $this->_cache->saveData($this->getSystem(),$this->_getParams($aData));
    }
    
    function _getCookie($aConfig) {
        if(!isset($_COOKIE['url']) || !isset($_COOKIE['act'])) return false;
        $aData = $this->_cache->getData($_COOKIE['url']);
        if(!isset($aData['data'][$_COOKIE['act']]) || empty($aData['data'][$_COOKIE['act']])) return false;
        
        $aTemp = $aData['data'][$_COOKIE['act']];
        // 系统参数
        $aResult = array(
            'url'=>$aData['url'],
            'token'=>$aData['token'],
        );
        
        // 必要参数的提交
        foreach($aConfig as $item) {
            $aResult['required'][$item] = $aTemp[$item];
            unset($aTemp[$item]);
        }
        
        // 参数
        $aResult['post'] = $aTemp();
        return $aResult;
    }
    
    function _getDefault($aConfig) {
        // 系统参数
        $aResult = array(
            'url'=>'',
            'token'=>'',
        );
        // 必要参数的提交
        foreach($aConfig as $item) {
            $aResult['required'][$item] = "";
        }
        // 参数
        $aResult['post'] = array();
        
        return $aResult;
    }
    
    function _getPost($aConfig) {
        $aResult = array();
        // 系统参数
        if(isset($_POST['url']) && ($_POST['url'] && $_POST['url'] != "http://")) {
            $aResult['url'] = $_POST['url'];
            if(strpos($aResult['url'],"http://") === false) $aResult['url'] = "http://".$aResult['url'];
        }
        if(isset($_POST['token'])) $aResult['token'] = $_POST['token'];
        
        // 必要参数的提交
        // $aResult['required'] = $_POST['required'];
        $aResult['required'] = array();
        foreach($aConfig as $item) {
            $aResult['required'][$item] = $_POST['required'][$item];
        }
        
        // 参数
        $aResult['post'] = array();
        $aTemp = (isset($_POST['name']))? $_POST['name'] : array();
        foreach($aTemp as $key=>$item) {
            $aResult['post'][$item] = $_POST['value'][$key];
        }
        return $aResult;
    }
    
    function _getParams($aData) {
        return array_merge((array)$aData['required'],(array) $aData['post']);
    }
    
    function request($aData) {
        $aParams = $this->_getParams($aData);
        // 生成AC 也可能不叫AC
        if(defined("ACNAME") && ACNAME) {
            $aParams[ACNAME] = makeAC($aParams,$aData['token']);
        }
        
        if($aData['url']) { // 还是要验证是不是url的哈
           $snoopy = new Snoopy();
           if($snoopy->submit($aData['url'],$aParams)) {
               if(isset($aParams['format_json']) && $aParams['format_json']) {
                   if($aTemp = json_decode($snoopy->results)) return print_r($aTemp,1);
               }
               return urldecode(str_replace("&gt;&lt;","&gt;<br/>&lt;",htmlentities($snoopy->results)));
           } else {
               return "请求失败";
           }
        }
        return false;
    }
    
    function run($aConfig) {
        $bFlag = false;
        if(empty($_POST)) {
            $aData = $this->_getCookie($aConfig);
            $aData = empty($aData)? $this->_getDefault($aConfig) : $aData;
        } else {
            $aData = $this->_getPost($aConfig);
            $bFlag = true;
        }
        
        $this->_url = $aData['url'];
        $this->_token = $aData['token'];
        $this->_required = $aData['required'];
        $this->_post = $aData['post'];
        $this->_result = ($bFlag)? $this->request($aData) : $this->_result;
        
        return $aData;
    }
    
    function getRequired() {
        return $this->_required;
    }

    function getPost() {
        if($this->_post) return $this->_post;
        return array(""=>"");
    }

    function getResult() {
        return $this->_result;
    }

    function getSystem() {
        return array("url"=>$this->_url,
                     "token"=>$this->_token
        );
    }
    
    function getHistory() {
        return $this->_cache->getList();
    }
}
?>