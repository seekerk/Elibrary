<?php

namespace App\Middelwares;

class ValidationErrorsMiddelware extends Middelware
{
	public function __invoke($request, $response, $next)
	{
		$this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
		unset($_SESSION['errors']);
		$response = $next($request, $response);
		return $response;
	}
}