<?php

namespace App\Middlewares;

class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($req, $resp, $next)
	{
		$this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
		unset($_SESSION['errors']);
		
		$resp = $next($req, $resp);
		return $resp;
	}
}
