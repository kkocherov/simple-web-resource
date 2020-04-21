<?php

include "users-model.php";

if ($requestUri == "/users") {
    $scriptAssets = ["/assets/js/users.js"];

    $handleRequest = function() {
        echo "
    <a href=\"/users/create\" class=\"btn btn-success\">Create new User</a>
    <div id='users-list'></div>
";
    };

    include "layout.php";
    die();
}

function handleView($user) {
    $handleRequest = function() use ($user) {
        include "templates/userView.php";
    };

    include "layout.php";
    die();
}

function handleEdit($user) {
    $scriptAssets = ['/assets/js/users-edit.js'];
    $userExists = isset($user["uuid"]);
    $handleRequest = function() use ($user, $userExists) {
        include "templates/userEdit.php";
    };

    include "layout.php";
    die();
}

function handleCreate() {
    $scriptAssets = ['/assets/js/users-edit.js'];
    $user = ["active" => true];
    $userExists = isset($user["uuid"]);

    $handleRequest = function() use ($user, $userExists) {
        include "templates/userEdit.php";
    };

    include "layout.php";
    die();
}

if ($requestUri == "/users/create") {
    handleCreate();
}

if (startsWith($requestUri, "/users/")) {
    $path = explode("/", $requestUri);
    $userUuid = $path[2];
    $user = getUser($userUuid);

    if (is_null($user)) {
        http_response_code(404);
        die();
    }

    if ($path[count($path) - 1] == 'edit') {
        handleEdit($user);
    } else {
        handleView($user);
    }
}

if ($requestUri == "/api/users") {
    header('Content-Type: application/json');

    if ($requestMethod == "GET") {
        echo json_encode(getUsers());
        die();
    }

    if ($requestMethod == "POST") {
        $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);
        $password = password_hash($password, PASSWORD_BCRYPT);
        echo json_encode(createUser($login, $password));
        die();
    }
}

if (startsWith($requestUri, "/api/users/")) {
    header('Content-Type: application/json');

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
        $isActive = filter_var($_POST['active'] ,FILTER_SANITIZE_STRING);

        $attributes = [];

        if (!empty($login)) {
            $attributes["login"] = $login;
        }

        if (!empty($password)) {
            $attributes["password"] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (!empty($isActive)) {
            $attributes["active"] = $isActive == 'true';
        }

        editUser($userUuid, $attributes);
        die();
    }

    if ($requestMethod == "DELETE") {
        deleteUser($userUuid);
        die();
    }
}