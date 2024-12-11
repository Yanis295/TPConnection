<?php

// Paramètres de connexion à la base de données
$dsn = 'mysql:host=mariadb;dbname=esgi;charset=utf8';
$username = 'esgi';
$password = 'esgipwd';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si la table `users` existe
    $result = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount();
    if ($result == 0) {

        // SQL pour créer la table `users` avec les nouvelles colonnes
        $createTableSQL = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                country VARCHAR(50) NOT NULL,
                city VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";

        // Exécuter la création de la table
        $pdo->exec($createTableSQL);

    }
} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou d'exécution SQL
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>
