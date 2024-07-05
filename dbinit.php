<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it does not exist
    $sql = "CREATE DATABASE IF NOT EXISTS ecommerce";
    $pdo->exec($sql);

    // Use the database
    $pdo->exec("USE ecommerce");

    // Create table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS jerseys (
        JerseyID INT AUTO_INCREMENT PRIMARY KEY,
        JerseyName VARCHAR(255) NOT NULL,
        JerseyDescription TEXT,
        QuantityAvailable INT NOT NULL,
        Price DECIMAL(10, 2) NOT NULL,
        ProductAddedBy VARCHAR(255) NOT NULL
    )";

    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>
