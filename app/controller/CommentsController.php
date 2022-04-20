<?php
namespace app\controller; 

class CommentsController{

  public function index()
  {
    echo "index of comment controller";
  }

  public function store($id)
  {
    echo "store of comment controller => " . $id;
  }

}