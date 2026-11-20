<?php

require_once __DIR__ . '/../model/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/index.php');
    exit;
}

try {
    $users = User::all();
} catch (PDOException $exception) {
    $users = [];
}

$accountCreated = isset($_GET['created']);

require __DIR__ . '/../view/users.php';
