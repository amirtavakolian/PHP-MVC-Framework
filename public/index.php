<?php
use app\core\router;
require dirname(__DIR__) . "\\bootstrap\\init.php";


/* 
echo "<pre>";
    print_r(router::getRoutes());
echo "</pre>";
 */


router::dispatch();



/* 


echo "<pre>";
    print_r();
echo "</pre>";

*/