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

        $dsn = getenv('DATABASE_URL');
        $database_connection = parse_url($dsn);

        $host = $database_connection['host'];
        $port = $database_connection['port'];
        $user = $database_connection['user'];
        $pass = $database_connection['pass'];
        $database = ltrim($database_connection['path'], '/');

        try {
            $pdo_dsn = 'pgsql:host='.$host.';port='.$port.';dbname='.$database;
            $pdo = new \PDO($pdo_dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            var_dump($e);
            die("cant connect to the database");
        }
    }

    return $pdo;
}






