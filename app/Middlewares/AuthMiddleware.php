<?php

namespace App\Middlewares;

class AuthMiddleware extends Middleware
{
    public function __invoke($req, $resp, $next)
    {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('error', 'Войдите, прежде чем сделать это!');

            return $resp->withRedirect($this->container->router->pathFor('home'));
        }

        $resp = $next($req, $resp);
		return $resp;
    }
}
