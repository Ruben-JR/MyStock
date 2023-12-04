<?php
    // Include Composer autoloader to load dependencies
    require_once __DIR__ . '/../vendor/autoload.php';

    use Symfony\Component\Routing\RouteCollection;
    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RequestContext;
    use Symfony\Component\Routing\Matcher\UrlMatcher;
    use Symfony\Component\Routing\Exception\ResourceNotFoundException;

    require_once 'router/product.php';

    // Instantiate the Router class and define routes
    $router = new Product\Routes\Router();
    $routeCollection = new RouteCollection();
    $router->defineRoutes($routeCollection);

    // Create a request context
    $requestContext = new RequestContext();
    $requestContext->fromRequest($_SERVER['REQUEST_URI']);

    // Create a URL matcher
    $matcher = new UrlMatcher($routeCollection, $requestContext);

    // Try to match the requested path
    try {
        $parameters = $matcher->match($_SERVER['REQUEST_URI']);
        // Handle the matched route here
        // You can use $parameters to get information about the matched route
        echo 'Handling route: ' . $parameters['_route'];
    } catch (ResourceNotFoundException $exception) {
        // Handle 404 error here
        echo '404 Not Found';
    }
?>
