<?php

class conf
{
    private pdo $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projet_prog_web', 'root', 'root');
    }

    public function getPDO() : pdo {
        return $this->pdo;
    }
}