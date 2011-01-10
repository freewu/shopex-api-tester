<?php
include_once("Snoopy.class.php");
class Process
{
    var $_data = null;
    var $_required = array();
    var $_url = null;
    var $_token = null;

    function Process($required = array()){
        // 必要参数的提交
        if(isset($_POST['required'])) $this->_required = $_POST['required'];
        if(empty($this->_required)) {
            foreach($required as $item) {
                $this->_required[$item] = "";
            }
        }

        // 系统参数
        if(isset($_POST['url']) && ($_POST['url'] && $_POST['url'] != "http://")) {
            $this->_url = $_POST['url'];
            if(strpos($this->_url,"http://") === false) $this->_url = "http://".$this->_url;
        }
        if(isset($_POST['token'])) $this->_token = $_POST['token'];

        // 参数
        $aTemp = (isset($_POST['name']))? $_POST['name'] : array();
        $aData = array();
        foreach($aTemp as $key=>$item) {
            $aData[$item] = $_POST['value'][$key];
        }
        $this->_data = $aData;
    }

    function getRequired() {
        return $this->_required;
    }

    function getPost() {
        if($this->_data) return $this->_data;
        return array(""=>"");
    }

    function getResult() {
        $aData = array_merge((array)$this->_required,(array)$this->_data);
        // 生成AC 也可能不叫AC
        if(defined("ACNAME") && ACNAME) {
            $aData[ACNAME] = $this->makeAC($aData,$this->_token);
        }
        if($this->_url) { // 还是要验证是不是url的哈
            $snoopy = new Snoopy();
            // 还有格式的转换
           $aData = array();
           if($snoopy->submit($this->_url,$aData)) {
               if(isset($_POST['format_json']) && $_POST['format_json']) {
                   if($aTemp = json_decode($snoopy->results)) return print_r($aTemp,1);
               }
               return urldecode(str_replace("&gt;&lt;","&gt;<br/>&lt;",htmlentities($snoopy->results)));
           } else {
               return "请求失败";
           }
        }
        return null;
    }

    function makeAC($aData = array(),$token = '') {
        return makeAC($aData,$token);
    }

    function getSystem() {
        return array("url"=>$this->_url,
                     "token"=>$this->_token
        );
    }
}
?>