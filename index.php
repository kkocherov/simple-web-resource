<?php

session_start();

$serverName = $_SERVER["HTTP_HOST"];
$documentRoot = $_SERVER["DOCUMENT_ROOT"];
$uploadFolder = $documentRoot.'/uploads';
$requestUri = $_SERVER["REQUEST_URI"];
$requestUri = explode("?", $requestUri);
$requestUri = $requestUri[0];
$requestMethod = $_SERVER["REQUEST_METHOD"];
$scriptAssets = [];

if (is_null($_SESSION["currentUser"]) && $requestUri != '/login' && $requestUri != '/auth') {
    header("Location: /login");
    die();
}

include "users-controller.php";

if ($requestUri == "/logout") {
    session_destroy();
    header("Location: /");
    die();
}

if ($requestUri == "/login") {
    include "login.html";
    die();
}

if ($requestUri == "/about") {
    $handleRequest = function() {
        echo "about";
    };

    include "layout.php";
    die();
}

if ($requestUri == "/profile") {
    $handleRequest = function() {
        echo "profile";
    };

    include "layout.php";
    die();
}


if ($requestUri == "/") {
    $handleRequest = function() {
        echo "ГЛАВНАЯ";
    };

    include "layout.php";
    die();
}

if ($requestUri == "/auth") {
    $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);


    foreach (getUsers() as $user) {
        if ($user['active'] && $user['login'] == $login && password_verify($password, $user['password'])) {
            $_SESSION["currentUser"] = $user;
        }
    }
    header("Location: /");
    die();
}


http_response_code(404);
die();
