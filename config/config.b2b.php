<?php
// 加密码算法
function makeAC($aData = array(),$token = '') {
    ksort($aData);
    $verify='';
    foreach($aData as $key=>$v){
        $verify.=$v;
    }
    return md5($verify.$token);
}

// ac名称  有的ac叫sign
define("ACNAME","ac");
define("METHOD","act"); // 请求的方法
define("TOOLSNAME","SHOPEX4.8.x API测试工具");

// 必填项
return array("act","api_version","return_data");
?>