CREATE DATABASE KhudaLagse;
USE food_delivery;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('customer','restaurant','admin') DEFAULT 'customer'
);
