<?php
define("APITYPE","b2b");  // 可选项b2b,ecos,platform,matrix
$data['url']='http://127.0.0.1:81/b2b_phpsrc/b2b126_matrix/src/api.php';
$data['token']='b7435ee52357a476116520e769e61f58818f6497f3b084c2a8fc89dc38afb581';

$data['format_json']=1;

/*
$data['act']='verify_products_valid';
$data['api_version']='3.1';
$data['return_data']='json';

$data['bns']=json_encode(array('xx'));
*/

$data['act']='ome_update_order_item';
$data['api_version']='3.1';
$data['return_data']='json';

$data['tid']='';
