<?php

namespace App\Middelwares;

class Middelware
{
    protected $container;
    
	public function __construct($container)
	{
		$this->container = $container;
	}
}