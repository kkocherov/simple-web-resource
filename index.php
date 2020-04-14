<?php

$login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);;

$users = [
  ["login" => 'admin@admin', 'password' => '$2y$10$jfyR.6xkg07xGY4/c/YJ4eWMJVmnOjPuBC6CTVhoD.fgSfyE/r2x6'],
  ["login" => 'guest@guest', 'password' => '$2y$10$kawxkMDPhNmTmo6WhkxV8uzmJRXP8harQvbZAT2e5aChE48yucGl6']
];

$currentUser = null;

foreach ($users as $user) {
    if ($user['login'] == $login && password_verify($password, $user['password'])) {
        $currentUser = $user;
    }
}

if (is_null($currentUser)) {
    echo "NE OK";
} else {
    echo "OK";
}
