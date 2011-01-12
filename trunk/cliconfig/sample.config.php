<?php
/****
 * 配置文件 规则：
 * 1, cliconfig 目录 下 以 .config.php 为后缀
 * 2, 定义 APITYPE .define("APITYPE","b2b");  // 可选项b2b,ecos,platform,matrix   
 * 3, 数据变量名为 $data , 关键字 url, token  及 相应api的 必须字段 要填 . 
 */  
define("APITYPE","b2b");  // 可选项b2b,ecos,platform,matrix
$data['url']='http://127.0.0.1:81/b2b_phpsrc/b2b126_matrix/src/api.php';
$data['token']='b7435ee52357a476116520e769e61f58818f6497f3b084c2a8fc89dc38afb581';

$data['format_json']=1;     // 是否 将返回结果 json decode.

/*
$data['act']='verify_products_valid';
$data['api_version']='3.1';
$data['return_data']='json';

$data['bns']=json_encode(array('xx'));
*/

//  api --  ome_update_order_item -- 修改订单
$data['act']='ome_update_order_item';
$data['api_version']='3.1';
$data['return_data']='json';

$data['tid']='20110112118652';
$data['total_goods_fee']='100';
$data['total_trade_fee']='200';
$data['payed_fee']='100';
$data['total_currency_fee']='200';
$data['currency']='CNY';
$data['currency_rate']='1';
$data['pay_cost']='0';
$data['orders_number']='3';
$data['total_weight']='800';
$data['orders_type']='json';
$data['orders']=json_encode(
array('order'=>
array(
array(
"oid"=>"1",
"type"=>"goods",
"type_alias"=>"商品",
"iid"=>"1",
"title"=>"衬衫",
"items_num"=>"1",
"order_status"=>"SHIP_NO",
"total_order_fee"=>"1200",
'order_items'=>
array('item'=>
array(
array(
"sku_id"=>"71",
"iid"=>"71",
"bn"=>"G49B7AD7F76E15-1",
"name"=>"2009耐克新款运动鞋 (蓝白混色、37)",
"price"=>"458.64",
"num"=>"1",
"weight"=>"0.5",
"score"=>"20",
"total_item_fee"=>"917.28",
"sendnum"=>"0",
"item_type"=>"product"
)
)
)
),
array(
"oid"=>"1",
"type"=>"goods",
"type_alias"=>"商品",
"iid"=>"1",
"title"=>"衬衫",
"items_num"=>"1",
"order_status"=>"SHIP_NO",
"total_order_fee"=>"1200",
'order_items'=>
array('item'=>
array(
array(
"sku_id"=>"002",
"iid"=>"1",
"bn"=>"G49B7B00DB597F-1",
"name"=>"多彩人生多彩裤",
"price"=>"99.000",
"num"=>"2",
"weight"=>"0.5",
"score"=>"20",
"total_item_fee"=>"99.0",
"sendnum"=>"0",
"item_type"=>"product"
)
)
)
),

)
)
);
