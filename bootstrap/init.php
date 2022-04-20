<?php
use app\core\request;
use app\core\router;
session_start();


require dirname(__DIR__) . "/vendor/autoload.php";
require __DIR__ . "/helper.php";
require dirname(__DIR__) . "/routes/web.php";


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



router::setRequest(new request());

