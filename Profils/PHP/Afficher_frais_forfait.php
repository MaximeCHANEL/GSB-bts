<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/Afficher_frais_forfait_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../assets/styles.css">
    <title>Frais - GSB</title>
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

<div class="container">
    <h2>Vos frais en cours</h2>
    <h3>
        Bonjour <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?>  
        <small>(mail : <?= $mail ?>)</small>  
        <small>(ID utilisateur : <?= $IdVisiteur ?>)</small>
    </h3>
    <p>Voici la liste de vos frais enregistrés :</p>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Justificatif</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($frais as $ligne): ?>
                <tr>
                    <td><?= ucfirst($ligne['libelle']) ?></td>
                    <td><?= $ligne['montant'] ?> €</td>
                    <td><?= $ligne['date'] ?></td>
                    <td><?= $ligne['justificatif'] ?></td>
                    <td><?= ucfirst($ligne['etat']) ?></td>
                    <td>
                        <?php
                        $modifier_desactive = false;
                        if ($ligne['etat'] === "Validée") {
                            $modifier_desactive = true;
                        } else {
                            foreach ($mois_jour_list as $mois) {
                                if ($mois_jour_actuel == $mois) {
                                    $modifier_desactive = true;
                                    break;
                                }
                            }
                        }
                        ?>
                        <?php if ($modifier_desactive): ?>
                            <input type="button" value="Modifier" disabled>
                        <?php else: ?>
                            <input type="button" value="Modifier"
                                   onclick="window.location.href='modification_frait_forfait.php?id=<?= $ligne['IdFrais'] ?>';">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2024 GSB. Tous droits réservés.</p>
</footer>
</body>
</html>
