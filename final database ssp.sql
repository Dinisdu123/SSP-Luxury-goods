CREATE DATABASE ecommerce;
USE ecommerce;

CREATE TABLE admins (
    AdminId INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Name VARCHAR(255) NOT NULL
);

CREATE TABLE customers (
    CustomerId INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Address TEXT,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20)
);

CREATE TABLE products (
    ProductId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    ImageUrl VARCHAR(255),
    Price DECIMAL(10, 2) NOT NULL,
    StockQuantity INT NOT NULL,
    Category VARCHAR(255),
    SubCategory VARCHAR(255)
);
select * from products;
CREATE TABLE cart (
    CartId INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT NOT NULL,
    ProductId INT NOT NULL,
    Quantity INT NOT NULL,
    AddedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalPrice DECIMAL(10, 2),
    FOREIGN KEY (UserId) REFERENCES customers(CustomerId),
    FOREIGN KEY (ProductId) REFERENCES products(ProductId)
);

CREATE TABLE orders (
    OrderId INT AUTO_INCREMENT PRIMARY KEY,
    CustomerId INT NOT NULL,
    OrderedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DeliveryAddress TEXT,
    OrderStatus ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    TotalPrice DECIMAL(10, 2),
    FOREIGN KEY (CustomerId) REFERENCES customers(CustomerId)
);
ALTER TABLE orders ADD ProductId INT NOT NULL;
ALTER TABLE orders ADD FOREIGN KEY (ProductId) REFERENCES products(ProductId);
select * from orders;
INSERT INTO orders (CustomerId, DeliveryAddress, OrderStatus, TotalPrice)
VALUES (1, '123 Sample Street, City, Country', 'Pending', 49.99);

CREATE TABLE reviews (
    ReviewId INT AUTO_INCREMENT PRIMARY KEY,
    CustomerId INT NOT NULL,
    ProductId INT NOT NULL,
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    ReviewText TEXT,
    ReviewDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CustomerId) REFERENCES customers(CustomerId),
    FOREIGN KEY (ProductId) REFERENCES products(ProductId)
);

DESCRIBE orders;

