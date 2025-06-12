<?php 
require __DIR__ . '/../../Connection_creation_bdd/con_bdd.php';

require __DIR__ . '/../Logique_PHP/detail_frais_logique.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du frais - GSB</title>
    <link rel="stylesheet" href="/../../assets/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <nav>
        <ul class="nav-list">
            <li><a href="espace_membre.php"><strong>GSB</strong></a></li>
            <li><a href="dashbord.php">Tableau de bord</a></li>
            <li><a href="index.html">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Détails du frais</h1>
        <div class="info">
            <p><strong>Nom :</strong> <?= htmlspecialchars($frais["Nom"]) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($frais["Prenom"]) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($frais["Date"]) ?></p>
            <p><strong>Montant :</strong> <?= number_format($frais["Montant"], 2, ',', ' ') ?> €</p>
            <p><strong>Type de frais :</strong> <?= htmlspecialchars($frais["Libelle"]) ?></p>
            <p><strong>Statut :</strong> 
                <span class="etat <?= str_replace(' ', '', $frais["Etat"]) ?>">
                    <?= htmlspecialchars($frais["Etat"]) ?>
                </span>
            </p>
            <p><strong>Justificatif :</strong>
                <?php if (!empty($frais["Justificatif"])): ?>
                    <a href="uploads/<?= htmlspecialchars($frais["Justificatif"]) ?>" target="_blank">Voir / Télécharger</a>
                <?php else: ?>
                    Aucun fichier disponible.
                <?php endif; ?>
            </p>
        </div>

        <form action="traitement_frais.php" method="POST">
            <input type="hidden" name="id_frais" value="<?= $idFrais ?>">
            <input type="hidden" name="id_visiteur" value="<?= $idVisiteur ?>">

            <label for="etat">Changer le statut :</label>
            <select id="etat" name="etat" required>
                <option value="Enattente" <?= $frais["Etat"] == "En attente" ? "selected" : "" ?>>En attente</option>
                <option value="Validee" <?= $frais["Etat"] == "Validé" ? "selected" : "" ?>>Validé</option>
                <option value="Refusee" <?= $frais["Etat"] == "Refusé" ? "selected" : "" ?>>Refusé</option>
            </select>

            <!-- <label for="etat">Changer le statut du paiement :</label>
            <select id="etat" name="etat" required>
                <option value="Enattente" <?= $frais["EtatPaiement"] == "Payé" ? "selected" : "" ?>>Payé</option>
                <option value="Validee" <?= $frais["EtatPaiement"] == "Impayé" ? "selected" : "" ?>>Impayé</option>
            </select> -->

            <div id="motif" class="motif">
                <label for="motif">Motif du refus :</label>
                <textarea name="motif" id="motif-textarea" placeholder="Expliquez brièvement le motif du refus..."></textarea>
            </div>

            <button type="submit">Mettre à jour</button>
        </form>

        <a href="ficheutilisateur.php?id=<?= urlencode($idVisiteur) ?>" class="btn">← Retour à la fiche</a>
    </div>

    <footer>
        <p>&copy; 2024 GSB - Tous droits réservés.</p>
    </footer>

    <script>
        const select = document.getElementById('etat');
        const motifDiv = document.getElementById('motif');

        function toggleMotif() {
            motifDiv.style.display = (select.value === 'Refusee') ? 'block' : 'none';
        }

        select.addEventListener('change', toggleMotif);
        window.addEventListener('load', toggleMotif);
    </script>
</body>
</html>
