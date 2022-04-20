<?php

function env($name){
  return $_ENV[$name];
}

function dump($data){
  return var_dump($data);
}

function view($file, $data = [])
{
  $file = str_replace(".", "/",$file);
  $file = dirname(__DIR__) . "/resources/views/".$file.".php";
  extract($data, EXTR_SKIP);

  if(is_readable($file)){
    include $file;
  }
}