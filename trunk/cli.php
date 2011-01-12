<?php
// exec('chcp 65001');
if(!defined("STDIN")) {
  define("STDIN", fopen('php://stdin','r'));
}
$actarg=strtolower($argv[1]);    
// 1, 选择config
if(in_array($actarg,climain::getconfigs())){
    $configfile=$actarg;
}elseif(in_array(substr($actarg,0,-11),climain::getconfigs())){
    $configfile=substr($actarg,0,-11);
}
do{
$act=trim($act);
// 1, 选择config
if($act=='l'||$act=='ls'){       
    $ls=climain::getconfigs();    
    echo "List ".count($ls)." config files : \n";
    foreach($ls as $k=>$v){
       echo "[$k]\t$v \n";
    }
    echo "Please input you chose key or filename:";
    $k=trim(fread(STDIN,80));
    if(isset($ls[$k])){
        $configfile=$ls[$k];
    }elseif(in_array($k,$ls)){
        $configfile=$k;
    }elseif(in_array(substr($k,0,-11),$ls)){
        $configfile=substr($k,0,-11);
    }
}

// 2, 载入config ,
if($configfile||is_file('cliconfig/'.$configfile)){
    echo "you chosed [$configfile]\n";
    $data=null;
    require('cliconfig/'.$configfile.'.config.php');
    if(!defined('APITYPE')||empty($data)){
       echo "config file: $configfile ,data Error \n";$configfile=null;continue 1; 
    }
    $required = require_once("config/config.".APITYPE.".php"); 
    foreach($required as $k){
        if(!strlen($data[$k])){
            echo "config file: $configfile ,\$data[$k] is required!  \n";$configfile=null;continue 2; 
        }
    }   
    // 3, 运行 api 
    include_once("lib/Snoopy.class.php");
    $climain=new climain;
    $r=$climain->process($data,$required);
    echo $r;
    break 1;
} 
// 4 , help
if($act=='quit'||$act=='q') break 1;
echo "Please type :
ls|l     \t... list all config files.
quit|q   \t... quit. 
";

}while($act = fread(STDIN, 80));
die('end.');

class climain{
    static public $configs;  
    static function getconfigs($configdir='cliconfig'){
        if(self::$configs) return self::$configs;
        $h=opendir($configdir);
        while (($d = readdir($h)) !== false) {
            if(substr($d,-11,11)=='.config.php'){
                self::$configs[]=substr($d,0,-11);
            } 
        }
        return self::$configs;
    }
    
    function process($data,$required){
        // 系统参数
        if(isset($data['url']) && ($data['url'] && $data['url'] != "http://")) {
            $this->_url = $data['url'];
            if(strpos($this->_url,"http://") === false) $this->_url = "http://".$this->_url;
        }
        if(isset($data['token'])) $this->_token = $data['token'];
        unset($data['url']);
        unset($data['token']);
        // 生成AC 也可能不叫AC
        if(defined("ACNAME") && ACNAME) {
            $data[ACNAME] = $this->makeAC($data,$this->_token);
        }
        
        if($this->_url) { // 还是要验证是不是url的哈
            $snoopy = new Snoopy();
            // 还有格式的转换
            
           if($snoopy->submit($this->_url,$data)) {
               if(isset($data['format_json']) && $data['format_json']) {
                   if($aTemp = json_decode($snoopy->results)) return print_r($aTemp,1);
               }
               return $snoopy->results; 
           } else {
               return "请求失败";
           }
        }
    }
    function makeAC($aData = array(),$token = '') {
        return makeAC($aData,$token);
    }
}