<?php

namespace App\Controllers;

use App\Models\Text;

class TextController extends BaseController
{
    public function findbyID($req, $resp)
    {
        $text = $this->Texts->findbyID($req->getParam('id'));

        return $this->view->render($resp, 'text.html', ['text' => $text]);
    }
}