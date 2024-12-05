<?php

namespace App\Controllers;

use App\Core\View;

class Main
{
    public function home(): void
    {
        session_start();

        // Vérifiez si les informations de l'utilisateur sont présentes dans la session
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user']['username'];
            $email = $_SESSION['user']['email'];
        } else {
            // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            header("Location: /login");
            exit();
        }
        $view = new View("Main/home.php");
        $view->addData("pseudo", $username);
        $view->addData("email", $email);
    }

}