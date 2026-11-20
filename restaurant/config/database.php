<?php

function connectDB(): PDO
{
    return new PDO(
        'mysql:host=127.0.0.1;port=3308;dbname=restaurant;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}
