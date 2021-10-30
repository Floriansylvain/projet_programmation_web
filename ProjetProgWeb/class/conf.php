<?php

require_once('dotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class conf
{
    private pdo $pdo;

    public function getPDO() : pdo {
        return new PDO('mysql:host=localhost;charset=UTF8;dbname=' . getenv('DBNAME'), getenv('USERNAME'), getenv('PASSWORD'));
    }
}