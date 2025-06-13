<?php
session_start();

require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/dashbord_logique.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Comptable - GSB</title>
    <link rel="stylesheet" href="/../../assets/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
            <li class="nav-item"><a href="#">Tableau de bord</a></li>
            <li class="nav-item">
                <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                <ul class="dropdown">
                    <li><a href="/../../index.html">Déconnexion</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h1>Suivi des frais des visiteurs</h1>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Total Frais</th>
                    <th>Statut</th>
                    <th>Action</th>
                    <th>Suivre Paiements</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($visiteurs as $visiteur): 
                $statut = ($visiteur["nbFrais"] > 0) ? "Validé" : "En cours";
                $classStatut = $statut === "Validé" ? "valide" : "encours";
            ?>
                <tr>
                    <td><?= htmlspecialchars($visiteur["Nom"]) ?></td>
                    <td><?= htmlspecialchars($visiteur["Prenom"]) ?></td>
                    <td><?= $visiteur["nbFrais"] ?></td>
                    <td class="<?= $classStatut ?>"><?= $statut ?></td>
                    <td>
                        <a class="button" href="ficheutilisateur.php?id=<?= $visiteur["IdVisiteur"] ?>">Consulter</a>
                    </td>
                    <td>
                        <a class="button" href="fichePaiements.php?id=<?= $visiteur["IdVisiteur"] ?>">Acces au Paiement</a>
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
