<?php
namespace app\core; 


class router {

  private static $routes = [];
  private static $request;
  private static $params = [];
  private static $namespace = "app\controller\\";

  // set routes
  public static function setRoute($uri, $target,$method)
  {
    $target = static::getTarget($target);
    static::getNamespace($target);
    $target += ["method"=>$method];
    $target += ["namespace"=>static::$namespace];
    $routeRE = static::createRegularRoute($uri, $target);

    static::createRoute($routeRE, $target);
  }

  public static function createRoute($routeRE, $target)
  {
    if(array_key_exists($routeRE, static::$routes)){
      if(!is_array(static::$routes[$routeRE]["method"])){ 
        if(static::$routes[$routeRE]["method"] != $target['method']){
          static::$routes[$routeRE]["target"] = [static::$routes[$routeRE]["method"]=>static::$routes[$routeRE]["target"], $target['method']=>$target['target']];
          static::$routes[$routeRE]["method"] = [static::$routes[$routeRE]["method"], $target['method']];
        }
      }else{
        if(!in_array($target['method'], static::$routes[$routeRE]["method"] )){
          array_push(static::$routes[$routeRE]["method"], $target['method']);
          static::$routes[$routeRE]["target"][$target['method']] = $target['target'];          
        }
      }
      return true;
    }
    static::$routes[$routeRE] = $target;

  }

  public static function createRegularRoute($uri, $target)
  {
    if ($uri != "/"){
      $routeRE = preg_replace("/^\//", "", $uri);
      $routeRE = preg_replace("/\//", "\/", $routeRE);
      $routeRE = preg_replace("/\{([a-z]+)\}/", '(?<\1>[a-z0-9]+)', $routeRE);
      $routeRE = "/^\/?" . $routeRE . "\/?$/i";
      return $routeRE;
    }
      $routeRE = "/^" . "\/" . "$/i";
      return $routeRE;
  }

  // set request object 
  public static function setRequest($req)
  {
    static::$request = $req;
  }
  
  public static function dispatch()
  {
    foreach(static::$routes as $key=>$value){

      
      if(preg_match($key, static::$request->getUri(), $matches)){ 
        
        /* 
        if(is_callable($value)){
          $value();
          die();
        } 
        */
        
        if(!static::checkHttpMethod($key)){
          header("HTTP/1.0 405 Method Not Allowed"); 
          view('errors.405', "kiri :D");
        }

        if(is_array(static::$routes[$key]["target"])){
          $target = explode("@", static::$routes[$key]["target"][static::$request->getMethod()]);
        }else{
          $target = explode("@", static::$routes[$key]["target"]);
        }

        $namespace = static::$routes[$key]["namespace"];
        
        if(!static::controllerClassExisted($target[0], $namespace)){
            die("class not found");
            }
        
        if(!static::controllerMethodExisted($target[0],$target[1], $namespace)){
            die("method not found");
        }
        $controller = $namespace.$target[0];
        $method = $target[1];
        
          foreach($matches as $str=>$val){
          if(is_string($str)){
            static::$params[$str] = $matches[$str];
         }
       }     
         $controllerObject = new $controller();
          call_user_func_array([$controllerObject,$method], static::$params);         
         die();
     }
    }
    die("route not found");
}

  public static function checkHttpMethod($key)
  {
    if(is_array(static::$routes[$key]["method"])){
      if(in_array(static::$request->getMethod(), static::$routes[$key]["method"]));
      return true;
    }
    return static::$routes[$key]["method"] == static::$request->getMethod();
  }


  public static function getRoutes()
  {
    return static::$routes;
  }


  public static function getTarget($target)
  {
    return is_array($target) ? $target : ["target"=>$target];
  }


  public static function getNamespace($target)
  {
    if(isset($target['namespace'])){
      static::$namespace .= $target['namespace'];
    }
  }


  public static function controllerClassExisted($controller, $namespace)
  {
    return class_exists($namespace.$controller);
  }

  public static function controllerMethodExisted($controller, $method, $namespace)
  {
    return method_exists($namespace.$controller, $method);
  }

  public static function get($uri, $target)
  {
    static::setRoute($uri,$target,"get");
  }
  
  public static function post($uri, $target)
  {
    static::setRoute($uri,$target,"post");
  }

  public static function put($uri, $target)
  {
    static::setRoute($uri,$target,"put");
  }

}