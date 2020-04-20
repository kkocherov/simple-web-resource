<?php

include "users-model.php";

if ($requestUri == "/users") {
    $scriptAssets = ["/assets/js/users.js"];

    $handleRequest = function() use($users) {
//        include "usersList.php";
        echo "<div id='users-list'></div>";
    };

    include "layout.php";
    die();
}


if ($requestUri == "/api/users") {
    if ($requestMethod == "GET") {
        echo json_encode(getUsers());
        die();
    }

    if ($requestMethod == "POST") {
        $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);
        $password = password_hash($password, PASSWORD_BCRYPT);
        echo createUser($login, $password);
        die();
    }
}

if (startsWith($requestUri, "/api/users/")) {
    $path = explode("/", $requestUri);
    $userUuid = $path[count($path) - 1];
    $user = getUser($userUuid);

    if (is_null($user)) {
        http_response_code(404);
        die();
    }

    if ($requestMethod == "GET") {
        echo json_encode(getUser($userUuid));
        die();
    }

    if ($requestMethod == "POST") {
        $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);

        $attributes = [];

        if (!empty($login)) {
            $attributes["login"] = $login;
        }

        if (!empty($password)) {
            $attributes["password"] = password_hash($password, PASSWORD_BCRYPT);
        }

        editUser($userUuid, $attributes);
        die();
    }

    if ($requestMethod == "DELETE") {
        deleteUser($userUuid);
        die();
    }
}