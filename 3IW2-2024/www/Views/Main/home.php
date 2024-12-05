<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user'])) {
        $firstName = isset($_SESSION['user']['first_name']) ? htmlspecialchars($_SESSION['user']['first_name']) : 'Utilisateur';
        echo "<h1>Bienvenue, $firstName !</h1>";
        echo '<a href="/logout">Se deconnecter</a>';
    } else {
        echo '<h1>Bienvenue sur notre site !</h1>';
        echo '<a href="/login">Se connecter</a>';        
        echo '<a href="/register">S\'inscrire</a>';
    }
    ?>
</body>
</html>