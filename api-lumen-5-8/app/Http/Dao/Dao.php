<?php

namespace App\Http\Dao;
use Illuminate\Support\Facades\DB;

class Dao
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public static function last() {
      $result = DB::select('SELECT LAST_INSERT_ID() as id');
      return $result[0];
    }
}
