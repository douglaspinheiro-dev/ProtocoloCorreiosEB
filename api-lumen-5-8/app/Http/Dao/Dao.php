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
        // DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    public static function last() {
        $result = DB::select('SELECT LAST_INSERT_ID() as id');
        return $result[0];
    }
}


/* <?php
namespace lib;
class Dao
{
    private static $Dao;
    private static $Pdo;

    final private function __construct()
    {
        try {
            self::$Pdo = new \PDO("mysql:host=" . CONEXAO['host'] . ";dbname=" . CONEXAO['database'], CONEXAO['user'], CONEXAO['password']);
            self::$Pdo->exec("SET TIME_ZONE = '-03:00'");
            self::$Pdo->exec("set names " . APP_CHARSET);
            self::$Pdo->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            self::$Pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$Pdo->query("SET group_concat_max_len = " . GROUP_CONCAT_MAX_LEN);
        } catch (\PDOException $ex) {
            throw new SystemExceptions($ex->getMessage());
        }
    }

    //...

} */
