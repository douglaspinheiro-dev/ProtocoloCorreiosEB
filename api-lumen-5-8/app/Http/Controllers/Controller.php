<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Dao\PermissoesModuloDao;
use Illuminate\Http\Request;
use App\ChromePhp;

class Controller extends BaseController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsuario()
    {
        return $this->request->auth['0']->usuario;
    }
}
