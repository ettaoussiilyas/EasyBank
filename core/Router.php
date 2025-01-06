<?php

    class Router{

        private $routes = [
            'GET' => [],
            'POST' => []
        ];

        //add a route
        public function add($method, $route, $callback){

            $method = strtoupper($method);

            //convert route to regex for dynamic parametres
            $route = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            $this->routes[$method][$route] = $callback;

        }

        //dispatsh the array routes
        public function dispatch($uri , $method){

            //remove query string
            $uri = parse_url($uri , PHP_URL_PATH);
            $method = strtoupper($method);

            foreach($this->routes[$method] as $route => $callback){
                // Check if the route matches
                if(preg_match('#^' . $route . '$#', $uri, $matches)){
                    array_shift($matches); //remove the full match
                    
                    //check if the callback is an array (controller and method)
                    if(is_array($callback)){
                        // Make sure the controller is an instance
                        $controller = new $callback[0];
                        $method = $callback[1];
    
                        return call_user_func_array([$callback, $method], $matches);
                    }

                    // Otherwise, call the callback directly
                    return call_user_func_array($callback, $matches);

                }
            }

            http_response_code(404);
            echo "404 - Not Found";
        }
    }

?>