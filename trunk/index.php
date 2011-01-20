<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$type = (isset($_COOKIE['type']) && $_COOKIE['type'])? $_COOKIE['type'] : "b2b"; // b2b为默认吧
define("APITYPE",$type);  // 可选项b2b,ecos,platform,matrix
include_once("lib/Process.class.php");
$required = require_once("config/config.".APITYPE.".php");
$oProcess = new Process($required);

$types = $oProcess->getTypes();
$required = $oProcess->getRequired();
$post = $oProcess->getPost();
$result = $oProcess->getResult();
$system = $oProcess->getSystem();
$history = $oProcess->getHistory();

//echo "<pre>";print_r($history);die;

include_once("template/index.html");
?>