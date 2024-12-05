<?php
namespace App\Controllers;

use App\Core\SQL;
use App\Core\View;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new SQL();
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Récupération des données du formulaire
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $pwdConfirm = $_POST['pwdConfirm'];
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $country = trim($_POST['country']);
            $city = trim($_POST['city']);

            // Validation des champs
            if (empty($username) || empty($email) || empty($password) || empty($pwdConfirm) || empty($first_name) || empty($last_name) || empty($country) || empty($city)) {
                $errors[] = "Tous les champs sont obligatoires.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            }

            if ($password !== $pwdConfirm) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }

            // Vérification de l'unicité de l'email
            if ($this->userExists($email)) {
                $errors[] = "L'email est déjà utilisé.";
            }

            if (empty($errors)) {
                // Hashage du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Insertion en BDD de l'utilisateur
                $this->createUser($username, $email, $hashedPassword, $first_name, $last_name, $country, $city);

                // Redirection vers la page de login
                header("Location: /login");
                exit();
            } else {
                // Affichage des erreurs
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            }
        } else {
            // Afficher le formulaire d'inscription
            $view = new View("User/register.php", "front.php");
            echo $view;
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Vérification des données
            if (empty($email) || empty($password)) {
                echo "<p>Tous les champs sont obligatoires.</p>";
            } elseif ($this->verifyUser($email, $password)) {
                // Crée la session utilisateur
                session_start();
                $user = $this->getUserByEmail($email);
                $_SESSION['user'] = [
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name']
                ];

                // Redirige vers la page d'accueil
                header("Location: /");
                exit();
            } else {
                echo "<p>Identifiants incorrects.</p>";
            }
        } else {
            $view = new View("User/login.php", "front.php");
            echo $view;
        }
    }

    private function getUserByEmail(string $email): array
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);
        header("Location: /");
        exit();
    }

    private function userExists(string $email): bool
    {
        $stmt = $this->db->getPdo()->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    private function createUser(string $username, string $email, string $password, string $first_name, string $last_name, string $country, string $city): void
    {
        $stmt = $this->db->getPdo()->prepare("
            INSERT INTO users (username, email, password, first_name, last_name, country, city) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$username, $email, $password, $first_name, $last_name, $country, $city]);
    }

    private function verifyUser(string $email, string $password): bool
    {
        $stmt = $this->db->getPdo()->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $hashedPassword = $stmt->fetchColumn();
        return $hashedPassword && password_verify($password, $hashedPassword);
    }
}

