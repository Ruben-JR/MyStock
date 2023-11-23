<?php
    namespace Auth\Http\Middleware;

    use Symfony\Component\HttpFoundation\Request;

    class AuthenticationMiddleware {

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
