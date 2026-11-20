<?php

require_once __DIR__ . '/../model/DiningTable.php';
require_once __DIR__ . '/../model/MenuItem.php';
require_once __DIR__ . '/../model/OrderItem.php';
require_once __DIR__ . '/../model/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/index.php');
    exit;
}

$tableId = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
$table = DiningTable::find($tableId);

if ($table === null) {
    header('Location: tables.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderAction = $_POST['action'] ?? '';

    if ($orderAction === 'add') {
        $menuItem = MenuItem::find((int) ($_POST['id_item'] ?? 0));

        if ($menuItem !== null) {
            OrderItem::add($tableId, (int) $menuItem['id_item']);
        }
    } elseif ($orderAction === 'more') {
        OrderItem::increase((int) ($_POST['line'] ?? 0), $tableId);
    } elseif ($orderAction === 'less') {
        OrderItem::decrease((int) ($_POST['line'] ?? 0), $tableId);
    } elseif ($orderAction === 'remove') {
        OrderItem::remove((int) ($_POST['line'] ?? 0), $tableId);
    } elseif ($orderAction === 'pay') {
        $total = OrderItem::totalOf(OrderItem::forTable($tableId));

        DiningTable::free($tableId);

        header('Location: tables.php?paid=' . urlencode(number_format($total, 2)));
        exit;
    }

    header('Location: order.php?id=' . $tableId);
    exit;
}

if ($table['status'] === 'available') {
    DiningTable::occupy($tableId, (int) $_SESSION['user_id']);
    $table = DiningTable::find($tableId);
}

$waiter = $table['id_user'] !== null ? User::find((int) $table['id_user']) : null;

$orderLines = OrderItem::forTable($tableId);
$total = OrderItem::totalOf($orderLines);

$menuByCategory = [];
foreach (MenuItem::all() as $menuItem) {
    $menuByCategory[$menuItem['category_name']][] = $menuItem;
}

require __DIR__ . '/../view/order.php';
