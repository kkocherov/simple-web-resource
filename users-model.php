<?php

include "util.php";

/**
 * @param $login
 * @param $password
 * @return mixed
 * @throws LengthException password length < 6
 * @throws InvalidArgumentException login is not unique
 */
function createUser($login, $password) {
    if (mb_strlen($password) < 6) {
        throw new LengthException("invalid password");
    }

    $pdo = getConnection();
    $statement = $pdo->prepare("insert into users(login, password) values(?, ?) returning *");

    try {
        $statement->execute([$login, password_hash($password, PASSWORD_BCRYPT)]);
        return $statement->fetch();
    } catch (PDOException $exception) {
        throw new InvalidArgumentException("duplicate login");
    }
}

function deleteUser($uuid) {
    editUser($uuid, ["active" => false]);
}

/**
 * @param $user
 * @param $attributes
 * @throws LengthException password length < 6
 * @throws InvalidArgumentException login is not unique
 */
function editUser($user, $attributes) {
    if (!is_null($attributes['password']) && mb_strlen($attributes['password']) < 6) {
        throw new LengthException("invalid password");
    }

    $pdo = getConnection();
    $newUser = array_merge($user, $attributes);
    $password = password_hash($newUser['password'], PASSWORD_BCRYPT);
    $statement = $pdo->prepare("update users set login = ?, password = ?, active = ?, image = ? where id = ?");
    $newUser['active'] = $newUser['active'] ?  'true' : 'false';

    try {
        $statement->execute([$newUser['login'], $password, $newUser['active'], $newUser['image'], $user["id"]]);
    } catch (PDOException $exception) {
        if ($exception->errorInfo[0] === 23505)
            throw new InvalidArgumentException("duplicate login");
        throw $exception;
    }
}

function getUser($id) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users where id = ?");
    $statement->execute([$id]);
    return $statement->fetch();
}

function getUsers($limit = PHP_INT_MAX, $page = 0)  {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users limit ? offset ?");
    $statement->execute([$limit, $page * $limit]);
    return $statement->fetchAll();
}

function findUser($login) {
    $pdo = getConnection();
    $result = $pdo->query("select * from users where login = '$login'");
    $user = $result->fetch();

    if ($user === false)
        return null;
    else
        return $user;
}