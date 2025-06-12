<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/fiche_utilisateur_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche utilisateur - GSB</title>
    <link rel="stylesheet" href="/../../assets/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1>Frais de <?= htmlspecialchars($notes[0]["Nom"]) . ' ' . htmlspecialchars($notes[0]["Prenom"]) ?></h1>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Montant</th>
                    <th>Type de frais</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $note): 
                    $classStatut = strtolower(str_replace(' ', '', $note["Etat"])); 
                ?>
                <tr>
                    <td><?= htmlspecialchars($note["Date"]) ?></td>
                    <td class="<?= $classStatut ?>"><?= htmlspecialchars($note["Etat"]) ?></td>
                    <td><?= number_format($note["Montant"], 2, ',', ' ') ?> €</td>
                    <td><?= htmlspecialchars($note["TypeFrais"]) ?></td>
                    <td>
                        <a class="consulter-btn" href="detailfrais.php?id=<?= urlencode($idVisiteur) ?>&frais_id=<?= urlencode($note['IdFrais']) ?>">
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
