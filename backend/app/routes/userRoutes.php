// routes/web.php or routes/api.php
<?php
    namespace User\Routes;

    use Symfony\Component\HttpFoundation\Request; // Import the Request class
    use Symfony\Component\Routing\Route; // Import the Route class

    class UserRouter
    {
        private $router;

        public function __construct()
        {
            $this->router = new Route();
        }

        public function defineRoutes()
        {
            // Define your routes here, as shown in the previous response
            // Example:
            // $this->addRoute('/products', 'ProductController@index');
            // $this->addRoute('/products/{id}', 'ProductController@show');
            // Users CRUD
            Route::get('/users', 'UserController@index');
            Route::post('/users', 'UserController@store');
            Route::get('/users/{id}', 'UserController@show');
            Route::put('/users/{id}', 'UserController@update');
            Route::delete('/users/{id}', 'UserController@destroy');
        }

        public function dispatch(Request $request)
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
