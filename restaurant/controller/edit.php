<?php

require_once __DIR__ . '/../model/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/index.php');
    exit;
}

$userId = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
$user = User::find($userId);

if ($user === null) {
    header('Location: users.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($firstName === '' || $lastName === '' || $email === '') {
        $error = 'Fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email';
    } elseif ($password !== '' && mb_strlen($password) < 3) {
        $error = 'Password must be at least 3 characters';
    } else {
        $userWithEmail = User::findByEmail($email);

        if ($userWithEmail !== null && (int) $userWithEmail['id_user'] !== $userId) {
            $error = 'Email already registered';
        } else {
            User::update($userId, $firstName, $lastName, $email);

            if ($password !== '') {
                User::updatePassword($userId, $password);
            }

            header('Location: users.php');
            exit;
        }
    }

    $user['first_name'] = $firstName;
    $user['last_name'] = $lastName;
    $user['email'] = $email;
}

require __DIR__ . '/../view/edit.php';
