// routes/web.php or routes/api.php
<?php
    namespace Product\Routes;

    class Router
    {
        public function defineRoutes()
        {
            // Define your routes here, as shown in the previous response
            // Example:
            // $this->addRoute('/products', 'ProductController@index');
            // $this->addRoute('/products/{id}', 'ProductController@show');
            // Products CRUD
            Route::get('/products', 'ProductController@index');
            Route::post('/products', 'ProductController@store');
            Route::get('/products/{id}', 'ProductController@show');
            Route::put('/products/{id}', 'ProductController@update');
            Route::delete('/products/{id}', 'ProductController@destroy');
        }

        public function dispatch(\Symfony\Component\HttpFoundation\Request $request)
        {
            // Extract the URI and method from the request
            $uri = $request->getPathInfo();
            $method = $request->getMethod();

            // Match the route and get the corresponding controller and action
            $route = $this->findRoute($uri, $method);

            // Create an instance of the controller
            $controllerName = $route['controller'];
            $controller = new $controllerName();

            // Call the specified action on the controller
            $actionName = $route['action'];
            $response = $controller->$actionName($request);

            return $response;
        }

        private function findRoute($uri, $method)
        {
            // Logic to find and return the corresponding route based on $uri and $method
            // You may use an array or other data structure to store your routes
        }
    }
?>
