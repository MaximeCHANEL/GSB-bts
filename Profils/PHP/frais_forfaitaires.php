<?php
session_start();
require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/frais_forfaitaires_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Frais Forfaitaires - GSB</title>
    <link rel="stylesheet" href="/../../assets/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
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
    <h2>Formulaire de frais forfaitaires</h2>
    <form name="forins" id="forins" method="post" action="frais_forfaitaires_processuss.php" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="libelle">Libellé :</label></td>
                <td>
                    <select name="libelle" id="type_frais" required>
                        <option value="">-- Veuillez choisir un type --</option>
                        <?php foreach ($frais_libelle as $libelle): ?>
                            <option value="<?= htmlspecialchars($libelle['Libelle_id']) ?>">
                                <?= htmlspecialchars($libelle['Libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="montant">Montant (€) :</label></td>
                <td>
                    <input type="text" name="montant" id="montant" required />
                    <p class="montant">Montant max : 300€. Au-delà, veuillez choisir "Autre" pour un frais hors forfait.</p>
                </td>
            </tr>
            <tr>
                <td><label for="date">Date :</label></td>
                <td><input type="date" name="date" id="date_hors_forfait" value="<?= $dateToday ?>" min="2000-01-01" max="2035-12-31" required /></td>
            </tr>
            <tr id="justificatifRow">
                <td><label for="justificatif">Justificatif :</label></td>
                <td><input type="file" name="justificatif" accept=".pdf, .jpg, .jpeg, .png"></td>
            </tr>
            <tr>
                <td colspan="2" id="buttonEnvoyer">
                    <input type="submit" id="envoi" name="Envoyer" value="Envoyer">
                    <input type="reset" id="rafraichir" value="Rafraîchir">
                </td>
            </tr>
        </table>
    </form>
</div>

<footer>
    <p>&copy; 2024 GSB. Tous droits réservés.</p>
</footer>

<script src="../JS/frais_forfaitaires.js"></script>
</body>
</html>
