-- Restaurant POS
-- Rebuilds the database from scratch
-- Warning: this deletes the whole database and creates it again
-- Import with: mysql.exe -u root --host=127.0.0.1 --port=3308 < database.sql

DROP DATABASE IF EXISTS restaurant;

CREATE DATABASE restaurant
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE restaurant;

CREATE TABLE `user` (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(75) NOT NULL,
    email VARCHAR(75) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE menu_item (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(75) NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    id_category INT NOT NULL,
    FOREIGN KEY (id_category) REFERENCES category(id_category)
);

CREATE TABLE dining_table (
    id_table INT AUTO_INCREMENT PRIMARY KEY,
    number INT NOT NULL UNIQUE,
    status ENUM('available', 'occupied') NOT NULL DEFAULT 'available',
    id_user INT NULL,
    opened_at DATETIME NULL,
    FOREIGN KEY (id_user) REFERENCES `user`(id_user)
);

CREATE TABLE order_item (
    id_order_item INT AUTO_INCREMENT PRIMARY KEY,
    id_table INT NOT NULL,
    id_item INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    UNIQUE KEY table_item (id_table, id_item),
    FOREIGN KEY (id_table) REFERENCES dining_table(id_table) ON DELETE CASCADE,
    FOREIGN KEY (id_item) REFERENCES menu_item(id_item)
);

-- Test user: admin@restaurant.com / admin123
INSERT INTO `user` (first_name, last_name, email, password) VALUES
('Admin', 'Restaurant', 'admin@restaurant.com', '$2y$10$ZR1so6PJZAP2nmYCFYnfOOLiQxEW0SMYzQd.dtTjMMy5B48AVl3dS');

INSERT INTO dining_table (number, status) VALUES
(1, 'available'),
(2, 'available'),
(3, 'available'),
(4, 'available'),
(5, 'available'),
(6, 'available'),
(7, 'available'),
(8, 'available');

INSERT INTO category (name) VALUES
('Food'),
('Drinks'),
('Desserts');

INSERT INTO menu_item (name, price, id_category) VALUES
('Grilled Chicken', 145.00, (SELECT id_category FROM category WHERE name = 'Food')),
('Beef Burger', 165.00, (SELECT id_category FROM category WHERE name = 'Food')),
('Pasta Alfredo', 135.00, (SELECT id_category FROM category WHERE name = 'Food')),
('Caesar Salad', 95.00, (SELECT id_category FROM category WHERE name = 'Food')),
('Club Sandwich', 120.00, (SELECT id_category FROM category WHERE name = 'Food')),
('Lemonade', 45.00, (SELECT id_category FROM category WHERE name = 'Drinks')),
('Iced Tea', 40.00, (SELECT id_category FROM category WHERE name = 'Drinks')),
('Coffee', 35.00, (SELECT id_category FROM category WHERE name = 'Drinks')),
('Bottled Water', 25.00, (SELECT id_category FROM category WHERE name = 'Drinks')),
('Craft Beer', 60.00, (SELECT id_category FROM category WHERE name = 'Drinks')),
('Cheesecake', 75.00, (SELECT id_category FROM category WHERE name = 'Desserts')),
('Chocolate Cake', 70.00, (SELECT id_category FROM category WHERE name = 'Desserts')),
('Flan', 65.00, (SELECT id_category FROM category WHERE name = 'Desserts')),
('Ice Cream', 55.00, (SELECT id_category FROM category WHERE name = 'Desserts'));
