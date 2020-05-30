<?php

use pomidorki\User;
use pomidorki\UsersRepository;

include "users-model.php";

function usersAddress($page, $limit) {
    return "/users?".http_build_query(["page" => $page, "limit" => $limit]);
}

if ($requestUri == "/users") {
    $scriptAssets = ["/assets/js/users.js"];

    $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
    $limit = filter_var($_GET['limit'] ?? 9, FILTER_VALIDATE_INT);

    $handleRequest = function() use ($page, $limit) {
        include "templates/usersView.php";
    };

    include "layout.php";
    die();
}

function handleView(User $user) {
    $handleRequest = function() use ($user) {
        include "templates/userView.php";
    };

    include "layout.php";
    die();
}

function handleEdit(User $user) {
    $scriptAssets = ['/assets/js/users-edit.js'];
    $userExists = !is_null($user->getId());
    $handleRequest = function() use ($user, $userExists) {
        include "templates/userEdit.php";
    };

    include "layout.php";
    die();
}

function handleCreate() {
    $scriptAssets = ['/assets/js/users-edit.js'];
    $user = ["active" => true];
    $userExists = isset($user["id"]);

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
    $userId = $path[2];
    $user = getUser($userId);
    $user = $usersRepository->getUser($userId);

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
        $limit = filter_var($_GET["limit"], FILTER_VALIDATE_INT);
        $page = filter_var($_GET["page"], FILTER_VALIDATE_INT);

        echo json_encode(getUsers($limit, $page));
        die();
    }

    if ($requestMethod == "POST") {
        $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);

        try {
            $user = createUser($login, $password);
            echo json_encode($user);
        } catch (LengthException $exception) {
            die("Слишком короткий пароль");
        } catch (InvalidArgumentException $exception) {
            die("Логин уже существует");
        }
        die();
    }
}

if (startsWith($requestUri, "/api/users/")) {
    header('Content-Type: application/json');

    $path = explode("/", $requestUri);
    $userId = filter_var($path[count($path) - 1], FILTER_VALIDATE_INT);
    $user = $usersRepository->getUser($userId);

    if (is_null($user)) {
        http_response_code(404);
        die();
    }

    if ($requestMethod == "GET") {
        echo json_encode(getUser($userId));
        die();
    }

    if ($requestMethod == "POST") {
        $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);
        $isActive = filter_var($_POST['active'] ,FILTER_SANITIZE_STRING);


        if (!$_FILES["picture"]["error"] == UPLOAD_ERR_NO_FILE) {
            $folder = $uploadFolder;
            $file_path = upload_image($_FILES["picture"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
            $file_url = "//$serverName/uploads/".$filename;
            $user->setPhoto($file_url);
        }

        if (!empty($login)) {
            $user->setLogin($login);
        }

        if (!empty($password)) {
            $user->setPassword($password);
        }

        $user->setActive($isActive == 'on');

        try {
            $usersRepository->update($user);
        } catch (LengthException $exception) {
            die("Слишком короткий пароль");
        } catch (InvalidArgumentException $exception) {
            die("Логин уже существует");
        } catch (Exception $exception) {
            die("Что то пошло не так, свяжитесь с нашей тех поддержкой");
        }

        die();
    }

    if ($requestMethod == "DELETE") {
        deleteUser($userId);
        die();
    }
}