<?php

require_once __DIR__ . '/../model/DiningTable.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/index.php');
    exit;
}

$tables = DiningTable::all();

$availableCount = count(array_filter($tables, fn ($table) => $table['status'] === 'available'));
$occupiedCount = count($tables) - $availableCount;

$welcome = isset($_GET['welcome']);

$paid = null;
if (isset($_GET['paid']) && is_numeric($_GET['paid'])) {
    $paid = number_format((float) $_GET['paid'], 2);
}

require __DIR__ . '/../view/tables.php';
