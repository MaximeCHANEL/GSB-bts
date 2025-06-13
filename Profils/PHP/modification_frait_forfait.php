<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/modification_frait_forfait_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un frais - GSB</title>
    <link rel="stylesheet" href="/../../assets/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
            <li class="nav-item"><a href="frais_forfaitaires.php">Saisie Frais</a></li>
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

<section>
    <div class="container">
        <h2>Modifier un frais</h2>
        <form method="post">
            <table>
                <tr>
                    <td><label for="libelle">Libellé :</label></td>
                    <td>
                        <select name="libelle" id="type_frais" required>
                            <?php foreach ($frais_libelle as $libelle): ?>
                                <option value="<?= $libelle['Libelle_id'] ?>"
                                    <?= ($libelle['Libelle_id'] == $frais['TypeFrais']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($libelle['Libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="montant">Montant (€) :</label></td>
                    <td><input type="text" name="montant" value="<?= htmlspecialchars($frais['Montant']) ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="date">Date :</label></td>
                    <td><input type="date" name="date" value="<?= htmlspecialchars($frais['Date']) ?>" min="2000-01-01" max="2035-12-31" required /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="Envoyer" value="Mettre à jour" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>

<footer>
    <p>&copy; 2024 GSB. Tous droits réservés.</p>
</footer>

<script src="../JS/modification_frait_forfait.js"></script>
</body>
</html>
