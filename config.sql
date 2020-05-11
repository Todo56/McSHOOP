CREATE DATABASE mcpeshoop;
USE mcpeshoop;
CREATE TABLE products(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50), description TEXT, long_description TEXT, price DECIMAL(7, 2), active INT DEFAULT 1, command TEXT, category INT, server INT, author INT, image VARCHAR(50));
CREATE TABLE servers(id INT PRIMARY KEY AUTO_INCREMENT, host VARCHAR(50), port VARCHAR(10), password VARCHAR(200));
CREATE TABLE categories(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50), description TEXT);
CREATE TABLE users(id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(30), password TEXT);
CREATE TABLE payments(id INT PRIMARY KEY AUTO_INCREMENT, pid INT, price DECIMAL(7, 2), username VARCHAR(100), order_id VARCHAR(100), bought_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

INSERT INTO products(name, description, long_description, price, command, category, server, author, image) VALUES ('First Product', 'This is your first product.', '# It gives you the following', 3.00, 'setgroup {player} rank', 1, 1, 1, '/assets/images/logo.png');
INSERT INTO servers(host, port, password) VALUES ('127.0.0.1', '19132', '123456789');
INSERT INTO categories(name, description) VALUES ('First Category', 'This is your first category.');
INSERT INTO users(username, password) VALUES ('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec');