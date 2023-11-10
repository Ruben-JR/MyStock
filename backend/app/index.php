<!-- The entry point of your application. routes requests to your application logic -->

<?php
    // Include Composer autoloader to load dependencies
    require_once __DIR__ . '/../vendor/autoload.php';
    // Bootstrap your application, including any configuration settings
    require_once __DIR__ . '/bootstrap.php';

    use App\Middleware\AuthenticationMiddleware;

     // Instantiate your middleware
     $authenticationMiddleware = new AuthenticationMiddleware();

     // Define a simple middleware stack
     $middlewareStack = [
         // Add other middleware instances as needed
         $authenticationMiddleware,
         // ... additional middleware instances
     ];

    // Handle the incoming request using your router
    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

    // Dispatch the request through the middleware stack
    $response = $this->dispatchMiddleware($request, $middlewareStack);

    // Create the router and define your routes
    $router = new \YourNamespace\Router();
    $router->defineRoutes(); // This method should define your application routes

    // Dispatch the request to the appropriate controller and action
    $response = $router->dispatch($request);

    // Send the response to the client
    $response->send();


    // Middleware dispatcher function
    function dispatchMiddleware($request, $middlewareStack)
    {
        $defaultHandler = function ($request) {
            // Default handler if no middleware left
            // You can replace this with your application's default behavior
            return new \Symfony\Component\HttpFoundation\Response('Not Found', 404);
        };

        // Create a closure for dispatching middleware
        $dispatcher = array_reduce(
            array_reverse($middlewareStack),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            $defaultHandler
        );

        // Dispatch the request through the middleware stack
        return $dispatcher($request);
    }
?>
