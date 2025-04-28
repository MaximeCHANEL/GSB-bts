<?php 
require 'con_bdd.php';

if (!isset($_GET['id']) || !isset($_GET['frais_id'])) {
    die("Paramètres manquants.");
}

$idVisiteur = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$idFrais = filter_var($_GET['frais_id'], FILTER_VALIDATE_INT);

if (!$idVisiteur || !$idFrais) {
    die("Paramètres invalides.");
}

try {
    $sql = "SELECT 
                u.Nom, 
                u.Prenom, 
                lf.Date, 
                lf.Montant, 
                ef.Etat, 
                tf.Libelle,
                lf.Justificatif
            FROM ligne_frais lf
            JOIN utilisateurs u ON lf.utilisateur_id = u.IdVisiteur 
            JOIN typefrais tf ON lf.TypeFrais = tf.Libelle_id
            JOIN etatfrais ef ON lf.Etat_Frais_id = ef.id_Etat_frais
            WHERE lf.IdFrais = :idFrais AND lf.utilisateur_id = :idVisiteur";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idFrais' => $idFrais, 'idVisiteur' => $idVisiteur]);
    $frais = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$frais) {
        die("Aucun détail trouvé pour ce frais.");
    }
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du frais - GSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f4f6f9;
        }

        nav {
            background-color: #098CFF;
            padding: 15px;
            color: white;
        }

        .nav-list {
            display: flex;
            justify-content: space-between;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding: 10px;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #098CFF;
            text-align: center;
            margin-bottom: 30px;
        }

        .info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .etat {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .etat.Validee {
            background-color: #d4edda;
            color: #155724;
        }

        .etat.Enattente {
            background-color: #fff3cd;
            color: #856404;
        }

        .etat.Refusee {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn, button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #098CFF;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover, button:hover {
            background-color: #0077cc;
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            resize: vertical;
        }

        .motif {
            display: none;
            margin-top: 15px;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background-color: #f1f1f1;
            color: #777;
        }
    </style>
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
