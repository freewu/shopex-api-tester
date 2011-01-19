<?php
// ecos的一些东东

// 加密码算法
function makeAC($aData = array(),$token = '') {
     return strtoupper(md5(strtoupper(md5(assemble($aData))).$token));
}

    
function assemble($params) {
    if(!is_array($params))  return null;
    ksort($params, SORT_STRING);
    $sign = '';
    foreach($params AS $key=>$val){
        if(is_null($val))   continue;
        if(is_bool($val))   $val = ($val) ? 1 : 0;
        $sign .= $key . (is_array($val) ? assemble($val) : $val);
    }
    return $sign;
}

// ac名称  有的ac叫sign
define("ACNAME","sign");
define("METHOD","method"); // 请求的方法
define("TOOLSNAME","ECOS API测试工具");

// 必填项
return array("app_id","method","date","format","cert_id","v","nod_id");
?>