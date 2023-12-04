<?php
    namespace Product\Routes;

    use Symfony\Component\Routing\Route;
    
    class Router {
        public function defineRoutes($routeCollection) {
            // Define your routes here
            $routeCollection->add(
                'create_products',
                new Route('/create-products', ['_controller' => 'ProductController@store'])
            );
            $routeCollection->add(
                'get_products',
                new Route('/get-products', ['_controller' => 'ProductController@index'])
            );
            $routeCollection->add(
                'get_products_id',
                new Route('/get-products-id/{id}', ['_controller' => 'ProductController@show'])
            );
            $routeCollection->add(
                'update_products',
                new Route('/update-products/{id}', ['_controller' => 'ProductController@update'])
            );
            $routeCollection->add(
                'delete_products',
                new Route('/delete-products/{id}', ['_controller' => 'ProductController@destroy'])
            );
        }
    }
?>
