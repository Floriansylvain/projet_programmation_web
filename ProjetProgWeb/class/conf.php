<?php

require_once('dotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class conf
{
    private pdo $pdo;

    public function getPDO() : pdo {
        return new PDO('mysql:host=localhost;dbname=' . getenv('DBNAME'), getenv('USERNAME'), getenv('PASSWORD'));
    }
}