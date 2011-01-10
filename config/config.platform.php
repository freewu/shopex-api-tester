<?php
/**
 * b2b&b2c数据同步平台的api测试配置
 *
 * b2c http://api-b2c.shopex.cn/api.php
 * b2b http://api-b2b.shopex.cn/api.php
 */

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

define("TOOLSNAME","平台API测试工具");

// 必填项
return array("act","api_version","return_data","certificate_id");
?>