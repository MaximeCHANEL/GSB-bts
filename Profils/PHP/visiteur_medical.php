<?php
session_start();

require __DIR__ . '/../Logique_PHP/visiteur_medical_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../assets/styles.css">
    <title>Espace Membre</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
                <li class="nav-item"><a href="frais_forfaitaires.php">Saisie Frais</a></li>
                <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste Frais</a></li>
                <li><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <ul class="dropdown">
                        <li><a href="/../../index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Bienvenue sur l'espace membre GSB</h2>
        <h3>
            Bonjour <strong><?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></strong><br>
            <small>(mail : <?= $mail ?>)</small><br>
            <small>(ID utilisateur : <?= $IdVisiteur ?>)</small>
        </h3>
        <p>Rôle : Visiteur Médical</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
