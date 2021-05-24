<?php

class Router{

    private $routes;

    public function __construct(){
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include ($routesPath);
    }

    //получаем строку запроса String
    private function getURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){

        $uri = $this->getURI();

        //проверяем наличие зароса в routes.php
        foreach ($this->routes as $uriPattern=>$path){
            if(preg_match("~$uriPattern~", $uri)){
//                echo '+';
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/',$internalRoute);
               //----------------
//                echo '<br>';
//                echo '<pre>';
//                print_r($segments);
//                echo '<pre>';
                //-----------
                //на основании запроса создаю имя класса контроллера для последующего вызова
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                //на основании запроса создаю имя метода (функции) контроллера для последующего вызова
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;
//                //-------------------
                echo '<br>';
                echo 'Class: ' . $controllerName;
                echo '<br>';
                echo 'Method: ' . $actionName;
//                ----------------

                //подключаю фаил класса контроллер и проверяю есть ли такой
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if (file_exists($controllerFile)){
                    include_once ($controllerFile);
                }

                //создаю обект класса и вызываю метод на оснвании полученных имен из запроса.
                $controllerObject = new $controllerName;

                $result = call_user_func_array(array ($controllerObject, $actionName), $parameters);
                if ($result !=null){
                    break;
                }

            }
        }

    }

}