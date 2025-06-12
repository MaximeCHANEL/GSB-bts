<?php
session_start();

require __DIR__ . '/../Logique_PHP/comptable_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Espace Membre</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <!-- Menu déroulant -->
                    <ul class="dropdown">
                        <li><a href="index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Bienvenue sur l'espace GSB</h2>
        <!-- Affichage des informations de session -->
        <h3>
            BONJOUR <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?> 
            (mail : <?= $mail ?>) 
            (id de l'utilisateur : <?= $IdVisiteur ?>)
        </h3>
        <p>Comptable</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>