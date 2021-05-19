<?php
class Router{
    private $routes;

    public function __construct()
    {
        // Путь к файлу с роутами
        $routesPath = ROOT . '/config/routes.php';

        // Получаем роуты из файла
        $this->routes = include($routesPath);
    }
   //метод возвращает строку
    private function getURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }

    }

    public function run(){

        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                echo '<br> Где ищем запрос который набрал пользователь: '.$uri;
                echo '<br> Что ищем совпадения из правила: '.$uriPattern;
                echo '<br> кто обрабатывает: '.$path;

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                echo '<br> нужно сформировать: '.$internalRoute;

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                echo '<br> contrlller name: '.$controllerName;
                echo '<br> contrlller name: '.$actionName;
                $parameters = $segments;
                echo '<pre>';
                print_r($parameters);

                //подключаем фаил класса-контроллера
                $controllerFile = ROOT . 'controllers/' .
                    $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
                // создаю обект контроллера и вызываем метод
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);
//                $result = $controllerObject->$actionName();
                if ($result != null){
                    break;
                }
            }

        }

        //проверяем наличие такого запроса в routes.php



    }
}