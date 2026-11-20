<?php

require_once __DIR__ . '/../config/database.php';

class MenuItem
{
    public static function all(): array
    {
        return connectDB()->query(
            'SELECT menu_item.id_item, menu_item.name AS item_name,
                    menu_item.price AS item_price,
                    category.name AS category_name
             FROM menu_item
             JOIN category ON category.id_category = menu_item.id_category
             ORDER BY menu_item.id_category, menu_item.name'
        )->fetchAll();
    }

    public static function find(int $itemId): ?array
    {
        $statement = connectDB()->prepare(
            'SELECT id_item, name AS item_name, price AS item_price
             FROM menu_item WHERE id_item = ? LIMIT 1'
        );
        $statement->execute([$itemId]);

        return $statement->fetch() ?: null;
    }
}
