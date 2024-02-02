<?php

// function getState()
// {
//     return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
// }

// function setState($state)
// {
//     list($a, $b, $c) = unserialize($state);
//     $_SESSION['hand'] = $a;
//     $_SESSION['board'] = $b;
//     $_SESSION['player'] = $c;
// }

// return new mysqli('hivedb', 'hiveuser', 'hivepassword', 'hive');

namespace Hive;

use mysqli;

class Database
{
    private function __construct()
    {
    }

    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new Database();
        }
        return $instance;
    }

    public function getState()
    {
        return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
    }

    public function setState($state)
    {
        list($a, $b, $c) = unserialize($state);
        $_SESSION['hand'] = $a;
        $_SESSION['board'] = $b;
        $_SESSION['player'] = $c;
    }

    public function connect()
    {
        return new mysqli('hivedb', 'hiveuser', 'hivepassword', 'hive');
    }
}
