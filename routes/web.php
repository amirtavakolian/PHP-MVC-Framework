<?php
use app\core\router;

// enable get & post for one route 



router::get("/", "HomeController@index");

// router::get("/amir", function(){echo "hello"});

router::get("/articles/show/{id}","ArticlesController@show");
router::get("/articles","ArticlesController@index");


router::get("/panel", ["target"=>"PanelController@index", "namespace"=>"panel"]);

router::get("/comments", ["target"=>"CommentsController@index"]);
router::put("/comments", ["target"=>"CommentsController@update"]);
router::post("/comments/{id}", ["target"=>"CommentsController@store"]);
