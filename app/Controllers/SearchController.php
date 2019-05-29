<?php

namespace App\Controllers;

use App\Models\Text;

class SearchController extends BaseController
{
    public function findbyKeyWords($req, $resp)
    {
        $keywords = $req->getParam('keywords');
        $keywords = preg_replace('/\w{,3}|[a-zA-Z]{2,}/', "", $keywords);

        $texts = Text::findbyKeyWords($keywords);

        return $this->view->render($resp, 'search.html', ['texts' => $texts]);
    }
}
