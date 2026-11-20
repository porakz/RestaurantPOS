<?php

require_once __DIR__ . "/../model/User.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/register.php");
    exit();
}

$firstName = trim($_POST["first_name"] ?? "");
$lastName = trim($_POST["last_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = (string) ($_POST["password"] ?? "");
$passwordConfirmation = (string) ($_POST["confirm_password"] ?? "");

if ($firstName === "" || $lastName === "" || $email === "" || $password === "") {
    $error = "Fill in all fields";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Enter a valid email";
} elseif (mb_strlen($password) < 3) {
    $error = "Password must be at least 3 characters";
} elseif ($password !== $passwordConfirmation) {
    $error = "Passwords must match";
} else {
    $error = null;
}

if ($error === null) {
    try {
        if (User::findByEmail($email) !== null) {
            $error = "Email already registered";
        } else {
            User::create($firstName, $lastName, $email, $password);
        }
    } catch (PDOException $exception) {
        $error =
            $exception->getCode() === "23000"
                ? "Email already registered"
                : "Database error";
    }
}

if ($error !== null) {
    header("Location: ../view/register.php?error=" . urlencode($error));
    exit();
}

if (isset($_SESSION["user_id"])) {
    header("Location: users.php?created=1");
    exit();
}

$user = User::findByEmail($email);

session_regenerate_id(true);
$_SESSION["user_id"] = (int) $user["id_user"];

header("Location: tables.php?welcome=1");
exit();
