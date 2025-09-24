CREATE DATABASE IF NOT EXISTS myappdb;
USE myappdb;

CREATE TABLE IF NOT EXISTS greetings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO greetings (name, message) VALUES
('Alice', 'Hello from Alice from pune!'),
('Bob', 'Welcome to the 3-tier demo in cbz'),
('Carol', 'This is a simple MySQL -> PHP -> NGINX example okkk');

