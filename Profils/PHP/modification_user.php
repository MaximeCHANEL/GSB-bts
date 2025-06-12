<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/modification_user_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../assets/styles.css">
    <title>Modifier un utilisateur</title>
</head>

<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
                <li class="date"><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($_SESSION['nom']) ?> <?= ucfirst($_SESSION['prenom']) ?></a>
                    <ul class="dropdown">
                        <li><a href="/../../index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="containerModifUser">
        <h2>Modifier un utilisateur</h2>
        <form method="post">
            <table>
                <tr>
                    <td><label for="nom">Nom :</label></td>
                    <td><input type="text" name="nom" id="nom" value="<?= htmlspecialchars($utilisateurs['Nom']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="prenom">Prénom :</label></td>
                    <td><input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($utilisateurs['Prenom']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="matricule">Matricule :</label></td>
                    <td><input type="text" name="matricule" id="matricule" value="<?= htmlspecialchars($utilisateurs['Matricule']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="ville">Ville :</label></td>
                    <td><input type="text" name="ville" id="ville" value="<?= htmlspecialchars($utilisateurs['Ville']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="mail">Mail :</label></td>
                    <td><input type="text" name="mail" id="mail" value="<?= htmlspecialchars($utilisateurs['Mail']) ?>"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Mettre à jour"></td>
                </tr>
            </table>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
