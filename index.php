<?php

use pomidorki\Router;
use pomidorki\NotFoundException;
use pomidorki\UsersRepository;

session_start();

$serverName = $_SERVER["HTTP_HOST"];
$documentRoot = $_SERVER["DOCUMENT_ROOT"];
$uploadFolder = $documentRoot.'/uploads';
$requestUri = $_SERVER["REQUEST_URI"];
$requestUri = explode("?", $requestUri);
$requestUri = $requestUri[0];
$requestMethod = $_SERVER["REQUEST_METHOD"];
$scriptAssets = [];

include "vendor/autoload.php";
include "db.php";

$usersRepository = new UsersRepository();

$usersRepository->addListener(function($event, $data) {
    error_log(print_r([$event, $data], true));
});


include "users-controller.php";


function equals($thisValue) {
    return function($thatValue) use ($thisValue) {  return $thatValue == $thisValue; };
}

function userAuthorized() {
    return !is_null($_SESSION["currentUser"]);
}

function authorizeUser($user)
{
    $_SESSION["currentUser"] = $user;
}

function loginPath() {
    return "/login";
}

function withAuth($handler) {
    return function() use ($handler) {
        if (!userAuthorized()) {
            header("Location: ".loginPath());
            return null;
        } else {
            return $handler();
        }
    };
}


$handleLogout = function() {
    session_destroy();
    header("Location: /");
    die();
};

$handleLogin = function () {
    include "login.html";
    die();
};

$handleAbout = function() {
    $handleRequest = function () {
        echo "about";
    };

    include "layout.php";
    die();
};

$handleProfile = function() {
    $handleRequest = function () {
        echo "profile";
    };

    include "layout.php";
    die();
};

$handleIndex = function() {
    $handleRequest = function () {
        echo "ГЛАВНАЯ";
    };

    include "layout.php";
    die();
};

$handleAuth = function() {
    $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $user = findUser($login);

    if (!is_null($user) && $user['active'] && password_verify($password, $user['password'])) {
        authorizeUser($user);
    }

    header("Location: /");
    die();
};

$routes = [
    '/test' => function() { echo "asdasd"; },
    '/logout' => $handleLogout,
    '/login' => $handleLogin,
    '/about' => withAuth($handleAbout),
    '/profile' => withAuth($handleProfile),
    '/' => withAuth($handleIndex),
    '/auth' => $handleAuth
];

function go($routes, $requestUri) {
    $router = new Router();
    foreach ($routes as $path => $handler) {
        $router->addRoute(equals($path),  $handler);
    }

    try {
        $router->handleRequest($requestUri);
    } catch (NotFoundException $exception) {
        http_response_code(404);
    }
}

go($routes, $requestUri);

die();
