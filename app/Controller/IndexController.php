<?php

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController('/')]
class IndexController extends AbstractController
{

    public function index()
    {
        return $this->response->raw('hello hyperf!!');
    }

}