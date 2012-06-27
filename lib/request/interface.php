<?php
interface request_interface {
    public function submit($url,$aParams,$aHeader = array());
    public function getResult(); 
} // end interface

