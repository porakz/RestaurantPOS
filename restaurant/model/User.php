<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    public static function findByEmail(string $email): ?array
    {
        $statement = connectDB()->prepare('SELECT * FROM `user` WHERE email = ? LIMIT 1');
        $statement->execute([$email]);

        return $statement->fetch() ?: null;
    }

    public static function countAll(): int
    {
        return (int) connectDB()->query('SELECT COUNT(*) FROM `user`')->fetchColumn();
    }

    public static function create(string $firstName, string $lastName, string $email, string $password): void
    {
        $statement = connectDB()->prepare(
            'INSERT INTO `user` (first_name, last_name, email, password) VALUES (?, ?, ?, ?)'
        );

        $statement->execute([$firstName, $lastName, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public static function verify(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }

    public static function find(int $userId): ?array
    {
        $statement = connectDB()->prepare(
            'SELECT id_user, first_name, last_name, email FROM `user` WHERE id_user = ? LIMIT 1'
        );
        $statement->execute([$userId]);

        return $statement->fetch() ?: null;
    }

    public static function all(): array
    {
        return connectDB()
            ->query('SELECT id_user, first_name, last_name, email FROM `user` ORDER BY id_user')
            ->fetchAll();
    }

    public static function update(int $userId, string $firstName, string $lastName, string $email): void
    {
        $statement = connectDB()->prepare(
            'UPDATE `user` SET first_name = ?, last_name = ?, email = ? WHERE id_user = ?'
        );
        $statement->execute([$firstName, $lastName, $email, $userId]);
    }

    public static function updatePassword(int $userId, string $password): void
    {
        $statement = connectDB()->prepare('UPDATE `user` SET password = ? WHERE id_user = ?');
        $statement->execute([password_hash($password, PASSWORD_DEFAULT), $userId]);
    }

    public static function delete(int $userId): void
    {
        $statement = connectDB()->prepare('DELETE FROM `user` WHERE id_user = ?');
        $statement->execute([$userId]);
    }
}
