<?php

namespace App\Controllers;

use App\Models\Text;

class SearchController extends BaseController
{
    public function findbyKeyWords($req, $resp)
    {
        $keywords = htmlEntities($req->getParam('keywords'), ENT_QUOTES);
        $keywords = preg_replace('/\w{,3}|[a-zA-Z]{2,}/',"", $keywords);

        $texts = $this->Texts->findbyKeyWords($keywords);

        return $this->view->render($resp, 'search.html', ['texts' => $texts]);
    }
}
