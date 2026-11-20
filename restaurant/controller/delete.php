<?php

require_once __DIR__ . '/../model/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: users.php');
    exit;
}

$userId = (int) ($_POST['id'] ?? 0);
$user = User::find($userId);

if ($user === null) {
    header('Location: users.php');
    exit;
}

User::delete($userId);

require __DIR__ . '/../view/deleteResult.php';
