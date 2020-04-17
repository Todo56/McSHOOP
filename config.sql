CREATE DATABASE mcpeshoop;
USE mcpeshoop;
CREATE TABLE products(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50), description TEXT, price DECIMAL(7, 2), active INT DEFAULT 1, command VARCHAR(100), category INT, server INT, author INT, image VARCHAR(50));
CREATE TABLE servers(id INT PRIMARY KEY AUTO_INCREMENT, host VARCHAR(50), port VARCHAR(10), password VARCHAR(200));
CREATE TABLE categories(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50), description TEXT);
CREATE TABLE users(id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(30), password TEXT);
CREATE TABLE payments(id INT PRIMARY KEY AUTO_INCREMENT, pid INT, price DECIMAL(7, 2), username VARCHAR(100), order_id VARCHAR(100), bought_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

INSERT INTO products(name, description, price, command, category, server, author, image) VALUES ('First Product', 'This is your first product.', 3.00, 'setgroup {player} rank', 1, 1, 1, '/assets/images/logo.png');
INSERT INTO servers(host, port, password) VALUES ('127.0.0.1', '19132', '$2y$12$N6FSH8yRo0YMQ4oPJHN1vOkv7GfK3OhVp22H/AjGoVLY.5Dm7ECYS');
INSERT INTO categories(name, description) VALUES ('First Category', 'This is your first category.');
INSERT INTO users(username, password) VALUES ('Todo56', '751e7461a106ae6a347b8a97b08a974b61bca6db66071d0e5dfdf6c13f709bda9b9c5febe40f24194ef1019eb3af10bd757063c15dc72f841092d5a8fac6b445');