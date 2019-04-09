<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index($req, $resp)
    {
        return $this->view->render($resp, 'home.html');
    }
}
