<?php

require_once __DIR__ . '/../config/database.php';

class DiningTable
{
    public static function all(): array
    {
        return connectDB()->query(
            'SELECT * FROM dining_table ORDER BY number'
        )->fetchAll();
    }

    public static function find(int $tableId): ?array
    {
        $statement = connectDB()->prepare('SELECT * FROM dining_table WHERE id_table = ? LIMIT 1');
        $statement->execute([$tableId]);

        return $statement->fetch() ?: null;
    }

    public static function occupy(int $tableId, int $userId): void
    {
        $statement = connectDB()->prepare(
            "UPDATE dining_table
             SET status = 'occupied', id_user = ?, opened_at = NOW()
             WHERE id_table = ?"
        );
        $statement->execute([$userId, $tableId]);
    }

    public static function free(int $tableId): void
    {
        $connection = connectDB();
        $connection->beginTransaction();

        try {
            $connection->prepare('DELETE FROM order_item WHERE id_table = ?')->execute([$tableId]);
            $connection->prepare(
                "UPDATE dining_table
                 SET status = 'available', id_user = NULL, opened_at = NULL
                 WHERE id_table = ?"
            )->execute([$tableId]);

            $connection->commit();
        } catch (Throwable $exception) {
            $connection->rollBack();
            throw $exception;
        }
    }
}
