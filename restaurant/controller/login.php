<?php

require_once __DIR__ . '/../model/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/index.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = (string) ($_POST['password'] ?? '');

try {
    $user = User::verify($email, $password);
} catch (PDOException $exception) {
    header('Location: ../view/index.php?database=1');
    exit;
}

if ($user === null) {
    unset($_SESSION['user_id']);
    header('Location: ../view/index.php?error=1');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id_user'];

header('Location: tables.php?welcome=1');
exit;
