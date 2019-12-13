<?php


namespace mywishlist\bd;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function start(string $file){

        $config = parse_ini_file($file);
        $db = new DB();
        $db->addConnection($config);
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}