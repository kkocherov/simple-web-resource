<?php

include "util.php";

define('USERS_FILE', "users-file.json");

function createUser($login, $password) {
    $uuid = randomUuid();
    $users = getUsers();
    $user = [
        "uuid" => $uuid,
        "login" => $login,
        "password" => $password,
        "active" => true
    ];
    $users[] = $user;
    file_put_contents(USERS_FILE, json_encode($users));
    return $user;
}


function deleteUser($uuid) {
    editUser($uuid, ["active" => false]);
}

function editUser($uuid, $attributes) {
    $users = array_map(function($user) use ($uuid, $attributes) {
        if ($user["uuid"] == $uuid) {
            return array_merge($user, $attributes);
        } else {
            return $user;
        }
    }, getUsers());

    file_put_contents(USERS_FILE, json_encode($users));
}

function getUser($uuid) {
    foreach (getUsers() as $user) {
        if ($user["uuid"] == $uuid) {
            return $user;
        }
    }

    return null;
}

function getUsers()  {
    if (file_exists(USERS_FILE)) {
        $result = file_get_contents(USERS_FILE);
        return json_decode($result, true);
    } else {
        throw new Exception("User file not found");
    }
}
