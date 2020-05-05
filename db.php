<?php


$pdo = null;


function getConnection() {
    global $pdo;

    if (is_null($pdo)) {
        $options = [
            \PDO::ATTR_EMULATE_PREPARES   => false,
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        $host = 'localhost';
        $db   = 'pomidorki';
        $user = 'tomato';
        $pass = 'tomato';

        $dsn = "pgsql:host=$host;dbname=$db";
        $pdo = new \PDO($dsn, $user, $pass, $options);
    }

    return $pdo;
}







