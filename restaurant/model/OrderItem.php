<?php

require_once __DIR__ . '/../config/database.php';

class OrderItem
{
    public static function forTable(int $tableId): array
    {
        $statement = connectDB()->prepare(
            'SELECT order_item.id_order_item, order_item.quantity,
                    menu_item.id_item, menu_item.name AS item_name,
                    menu_item.price AS item_price
             FROM order_item
             JOIN menu_item ON menu_item.id_item = order_item.id_item
             WHERE order_item.id_table = ?
             ORDER BY menu_item.id_category, menu_item.name'
        );
        $statement->execute([$tableId]);

        return $statement->fetchAll();
    }

    public static function add(int $tableId, int $itemId): void
    {
        $statement = connectDB()->prepare(
            'INSERT INTO order_item (id_table, id_item, quantity)
             VALUES (?, ?, 1)
             ON DUPLICATE KEY UPDATE quantity = quantity + 1'
        );
        $statement->execute([$tableId, $itemId]);
    }

    public static function increase(int $orderLineId, int $tableId): void
    {
        $statement = connectDB()->prepare(
            'UPDATE order_item SET quantity = quantity + 1 WHERE id_order_item = ? AND id_table = ?'
        );
        $statement->execute([$orderLineId, $tableId]);
    }

    public static function decrease(int $orderLineId, int $tableId): void
    {
        $connection = connectDB();

        $statement = $connection->prepare(
            'UPDATE order_item SET quantity = quantity - 1 WHERE id_order_item = ? AND id_table = ?'
        );
        $statement->execute([$orderLineId, $tableId]);

        $connection->prepare('DELETE FROM order_item WHERE id_order_item = ? AND id_table = ? AND quantity < 1')
            ->execute([$orderLineId, $tableId]);
    }

    public static function remove(int $orderLineId, int $tableId): void
    {
        $statement = connectDB()->prepare(
            'DELETE FROM order_item WHERE id_order_item = ? AND id_table = ?'
        );
        $statement->execute([$orderLineId, $tableId]);
    }

    public static function totalOf(array $orderLines): float
    {
        $total = 0;

        foreach ($orderLines as $orderLine) {
            $total += (float) $orderLine['item_price'] * (int) $orderLine['quantity'];
        }

        return (float) $total;
    }
}
