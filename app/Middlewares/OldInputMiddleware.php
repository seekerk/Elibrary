<?php

namespace App\Middlewares;

class OldInputMiddleware extends Middleware
{
	public function __invoke($req, $resp, $next)
	{
		$this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
		$_SESSION['old'] = $req->getParams();

		$resp = $next($req, $resp);
		return $resp;
	}
}