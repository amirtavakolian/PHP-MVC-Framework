<?php
namespace app\core;

class request {

  private $uri; 
  private $method;
  private $agent;
  private $remoteAddress; 
  private $queryString;
  private $params;

  public function __construct()
  {
    // $this->uri = explode("?", str_replace(env('REMOVE_FROM_URI'), "", $_SERVER['REQUEST_URI']))[0];    
    $this->uri = str_replace(env('REMOVE_EXTRA_FROM_URI'), "",explode("?", $_SERVER['REQUEST_URI'])[0]);
    $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    $this->agent = $_SERVER['HTTP_USER_AGENT'];
    $this->remoteAddress = $_SERVER['REMOTE_ADDR'];
    $this->queryString = $_SERVER['QUERY_STRING'];
    $this->params = $_REQUEST;
  }

  
  public function getUri(){
    return empty($this->uri) ? "/" : $this->uri;
  }

  public function getMethod(){
    return $this->method;
  }

  public function getAgent(){
    return $this->agent;
  }

  public function getRemoteAddress(){
    return $this->remoteAddress;
  }
  
  public function getQueryString(){
    return $this->queryString;
  }

  public function getParams()
  {
    return $this->params;
  }
  

}
