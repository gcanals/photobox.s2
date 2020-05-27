<?php
/**
 * File:  DbConf.php
 * Creation Date: 05/05/2015
 * description:
 *
 * @author: canals
 */

namespace photobox\utils;

use Illuminate\Database\Capsule\Manager as DB ;

class Eloquent {


    public static function init ($filename) {


        $db = new DB();
        $db->addConnection(parse_ini_file($filename));
        $db->setAsGlobal();
        $db->bootEloquent();

    }


}