<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php'; // Inclusion de la connexion à la BDD

require __DIR__ . '/../Logique_PHP/admin_logique.php';

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
                <li class="date"><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <ul class="dropdown">
                        <li><a href="/../../index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container" id="admin-container">
        <h2 class="list_user">Liste des utilisateurs</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Matricule</th>
                    <th>Ville</th>
                    <th>Mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= ucfirst($user['Nom']) ?></td>
                        <td><?= $user['Prenom'] ?></td>
                        <td><?= $user['Matricule'] ?></td>
                        <td><?= $user['Ville'] ?></td>
                        <td><?= $user['Mail'] ?></td>
                        <td>
                            <input type="button" value="Modifier" onclick="window.location.href='modification_user.php?id=<?= $user['IdVisiteur'] ?>';">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="/../../Inscription/inscription_gsb.php" class="list_user">
            <input id="button_user" type="submit" name="new_user" value="Ajouter un utilisateur">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
