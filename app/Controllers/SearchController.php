<?php

namespace App\Controllers;

use App\Models\Text;

class SearchController extends BaseController
{
    public function findbyKeyWords($req, $resp)
    {
        $keywords = htmlEntities($req->getParam('keywords'), ENT_QUOTES);

        $texts = $this->Texts->findbyKeyWords($keywords);

        return $this->view->render($resp, 'search.html', ['texts' => $texts]);
    }
}
