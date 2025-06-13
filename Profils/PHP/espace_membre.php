<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/espace_membre_logique.php';
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

                <?php if ($_SESSION['role_id'] == 3): ?>
                    <li class="nav-item"><a href="frais_forfaitaires.php">Saisies Frais</a></li>
                    <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste frais</a></li>
                <?php elseif ($_SESSION['role_id'] == 1): ?>
                    <li class="nav-item"><a href="admin.php">Liste Utilisateurs</a></li>
                <?php elseif ($_SESSION['role_id'] == 2): ?>
                    <li class="nav-item"><a href="dashbord.php">Comptable</a></li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="espace_membre.php">
                        Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?>
                    </a>
                    <ul class="dropdown">
                        <li><a href="/../../index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Bienvenue sur l'espace GSB</h2>
        <h3>
            Bonjour <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?> <br>
            (Mail : <?= htmlspecialchars($mail) ?>) <br>
            (ID utilisateur : <?= $IdVisiteur ?>)
        </h3>
        <p>Bienvenue dans votre espace personnel. Utilisez la barre de navigation pour gérer vos frais ou accéder à vos fonctionnalités selon votre rôle.</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
