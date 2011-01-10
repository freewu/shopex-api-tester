<?php
define("APITYPE","matrix");  // 可选项b2b,ecos,platform,matrix
include_once("lib/Process.class.php");
$required = require_once("config/config.".APITYPE.".php");
$oProcess = new Process($required);

$required = $oProcess->getRequired();
$post = $oProcess->getPost();
$result = $oProcess->getResult();
$system = $oProcess->getSystem();

include_once("template/index.html");
?>