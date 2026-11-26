<?php
abstract class BDD
{
    protected static ?PDO $pdo = null;

    public function __construct()
    {
        $fichier = __DIR__ . '/../../data/bd.sqlite';
        $fichier = __DIR__ . '/../../data/bd.sql';
        if(!file_exists($fichier)){
            die("Fichier Sqlite introuvable");
        }

        if (self::$pdo == null) {
           // self::$pdo = new PDO($fichier);


        self::$pdo = new PDO('sqlite:' . $fichier);

        self::$pdo->exec('PRAGMA foreign_keys = ON');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

}

}
