<?php

// Param�tres de connexion � la base de donn�es
$dsn = 'mysql:host=mariadb;dbname=esgi;charset=utf8';
$username = 'esgi';
$password = 'esgipwd';

try {
    // Connexion � la base de donn�es avec PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // V�rifier si la table `users` existe
    $result = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount();
    if ($result == 0) {

        // SQL pour cr�er la table `users` avec les nouvelles colonnes
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

        // Ex�cuter la cr�ation de la table
        $pdo->exec($createTableSQL);

    }
} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou d'ex�cution SQL
    die("Erreur de connexion � la base de donn�es : " . $e->getMessage());
}

?>
