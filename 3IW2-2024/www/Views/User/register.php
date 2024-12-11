<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Utilisateur</title>
</head>
<body>
    <h1>Inscription Utilisateur</h1>
    <form action="/register" method="post">
        <div>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="pwdConfirm">Confirmer le mot de passe:</label>
            <input type="password" id="pwdConfirm" name="pwdConfirm" required>
        </div>
        <div>
            <label for="first_name">Prenom:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div>
            <label for="last_name">Nom:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div>
            <label for="country">Pays:</label>
            <input type="text" id="country" name="country" required>
        </div>
        <div>
            <label for="city">Ville:</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div>
            <button type="submit">S'inscrire</button>
        </div>
    </form>
</body>
</html>
