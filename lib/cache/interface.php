<?php
interface cache_interface {    
    public function getList();
    public function getData($url,$act = null);           
    public function saveData($aSystem,$aData);
}
