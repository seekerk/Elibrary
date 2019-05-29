<?php

namespace App\Middlewares;

class GuestMiddleware extends Middleware
{
    public function __invoke($req, $resp, $next)
    {
        if ($this->container->auth->check()) {
            return $resp->withRedirect($this->container->router->pathFor('home'));
        }

        $resp = $next($req, $resp);
		return $resp;
    }
}