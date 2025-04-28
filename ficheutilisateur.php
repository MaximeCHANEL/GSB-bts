<?php
require 'con_bdd.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'utilisateur non spécifié.");
}

$idVisiteur = $_GET['id'];

$sql = "SELECT 
        utilisateurs.Nom, 
        utilisateurs.Prenom,
        ligne_frais.IdFrais, 
        ligne_frais.Date, 
        etatfrais.Etat, 
        ligne_frais.Montant, 
        TypeFrais.Libelle AS TypeFrais
        FROM ligne_frais
        JOIN utilisateurs ON ligne_frais.utilisateur_id = utilisateurs.IdVisiteur 
        JOIN etatfrais ON ligne_frais.Etat_Frais_id = etatfrais.id_Etat_frais
        JOIN TypeFrais ON ligne_frais.TypeFrais = TypeFrais.Libelle_id
        WHERE ligne_frais.utilisateur_id = :id 
        ORDER BY ligne_frais.Date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idVisiteur]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$notes) {
    die("Aucun frais trouvé pour cet utilisateur.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche utilisateur - GSB</title>
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
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #098CFF;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
        }

        .validee {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }

        .enattente {
            background-color: #fff3cd;
            color: #856404;
            font-weight: bold;
        }

        .refusee {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
        }

        .consulter-btn {
            background-color: #098CFF;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .consulter-btn:hover {
            background-color: #0077cc;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            color: #777;
            margin-top: 50px;
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
