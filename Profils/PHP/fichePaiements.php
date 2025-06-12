<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/fiche_paiements_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../assets/styles.css">
    <title>Fiche utilisateur - GSB</title>
</head>
<body>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
            <li class="nav-item"><a href="dashbord.php">Tableau de bord</a></li>
            <li class="nav-item">
                <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                <ul class="dropdown">
                    <li><a href="/../../index.html">Déconnexion</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h1>Choisir une fiche de frais</h1>

        <table>
            <thead>
                <tr>
                    <th>Nombre de Justificatifs</th>
                    <th>Montant Valide</th>
                    <th>Date de Modification</th>
                    <th>Nom du visiteur</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $note): 
                ?>
                <tr>
                    <td><?= htmlspecialchars($note["nbJustificatifs"]) ?></td>
                    <td><?= htmlspecialchars($note["montantValide"]) ?></td>
                    <td><?= htmlspecialchars($note["dateModif"]) ?></td>
                    <td><?= htmlspecialchars($note["prenom"]) ?> </td>
                    <td>
                        <a class="consulter-btn" href="detailsFichePaiement.php?id=<?= urlencode($idVisiteur) ?>&frais_id=<?= urlencode($note['id_FicheFrais']) ?>">
                            Consulter
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a class="back-btn" href="dashbord.php">← Retour au tableau de bord</a>
    </div>

    <footer>
        <p>&copy; 2024 GSB - Tous droits réservés.</p>
    </footer>
</body>
</html>
