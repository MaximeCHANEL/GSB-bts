<?php
require 'con_bdd.php';
session_start();

if (
    isset($_SESSION['IdVisiteur'], $_SESSION['nom'], $_SESSION['prenom'],
          $_SESSION['mail'], $_SESSION['dateToday'])
) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    echo "<script>window.location='connexion_gsb.html';</script>";
    exit();
}

// Requête pour récupérer les visiteurs et leurs frais
$sql = "SELECT 
            Nom, 
            Prenom,
            IdVisiteur,
            COUNT(hf.IdFrais) AS nbFrais
        FROM utilisateurs
        INNER JOIN ligne_frais hf ON IdVisiteur = utilisateur_id
        GROUP BY IdVisiteur";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$visiteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Comptable - GSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
        }

        nav {
            background-color: #098CFF;
            padding: 15px;
            color: white;
        }

        .nav-list {
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            font-size: 18px;
        }

        .nav-item a:hover {
            background-color: #0077cc;
            border-radius: 5px;
        }

        .dropdown {
            list-style: none;
            background-color: #098CFF;
            margin-top: 5px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #098CFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
        }

        .valide {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }

        .encours {
            background-color: #fff3cd;
            color: #856404;
            font-weight: bold;
        }

        a.button {
            padding: 8px 15px;
            background-color: #098CFF;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        a.button:hover {
            background-color: #0077cc;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            margin-top: 50px;
            color: #777;
        }
    </style>
</head>
<body>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>
            <li class="nav-item"><a href="#">Tableau de bord</a></li>
            <li class="nav-item">
                <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                <ul class="dropdown">
                    <li><a href="index.html">Déconnexion</a></li>
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
