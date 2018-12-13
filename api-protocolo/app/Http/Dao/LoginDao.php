<?php

namespace App\Http\Dao;
use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\ChromePhp;


class LoginDao extends Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public static function valida($obj) {
      $result =  DB::select("select * from usuarios where login = '{$obj['login']}'");
      if (Hash::check($obj['password'], $result['0']->password)) {
        ChromePhp::log('login VALIDO');
        return true;
      } else {return false;}
    }

    //
}
