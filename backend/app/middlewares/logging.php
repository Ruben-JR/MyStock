<?php
    namespace Login\Middleware;
    use Symfony\Component\HttpFoundation\Request;
    class ProductMiddleware {
        public function handle(Request $request, callable $next) {
            if (!$this->isAuthenticated()) {
                return new \Symfony\Component\HttpFoundation\Response('Unauthorized', 401);
            }
            return $next($request);
        }
        private function isAuthenticated() {
            return true;
        }
    }
?>
