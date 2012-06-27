<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

define("ROOT_DIR",dirname(__FILE__)."/");
include_once("config.php");


// === 获取配置信息 ================
include_once("lib/Config.class.php");
$oConfig = new Config();
$types   = $oConfig->getTypes();
$type    = $oConfig->getDefualtType();
$history = $oConfig->getHistory();
define("APITYPE",$type);  // 可选项b2b,ecos,platform,matrix
//$type = "b2b";

// === 提交处理 ====================
include_once("lib/Process.class.php");
$oProcess = new Process();
$required = require_once("config/config.".$type.".php");
$oProcess->setRequiredData($required);

$required = $oProcess->getRequired();
$post = $oProcess->getPost();
$result = $oProcess->getResult();
$system = $oProcess->getSystem();

//echo "<pre>";print_r($history);die;

include_once("template/index.html");
