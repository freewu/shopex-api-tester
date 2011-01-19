<?php
// matrix api 测试

// 加密码算法
function makeAC($aData = array(),$token = '') {
    ksort($aData);
    $sign = '';
    foreach($aData as $key => $value){
        $sign = $sign.$key.$value;
    }
    $sign = strtoupper(md5($sign));
    $sign = strtoupper(md5($sign.$token));
    return $sign;
}

// ac名称  有的ac叫sign
define("ACNAME","sign");
define("METHOD","method"); // 请求的方法
define("TOOLSNAME","矩阵API测试工具");

// 必填项
return array("app_id","method","date","format","cert_id","v","callback_url");
?>