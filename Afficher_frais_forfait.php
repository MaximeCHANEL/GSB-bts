<?php
session_start();

require 'con_bdd.php';

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

$req = $pdo->prepare("
    SELECT ligne_frais.IdFrais, typefrais.libelle AS libelle, 
           ligne_frais.Montant AS montant, ligne_frais.Date AS date, 
           ligne_frais.justificatif AS justificatif, etatfrais.Etat AS etat
    FROM ligne_frais
    INNER JOIN typefrais ON ligne_frais.TypeFrais = typefrais.Libelle_id
    INNER JOIN etatfrais ON ligne_frais.Etat_Frais_id = etatfrais.id_Etat_frais
    WHERE ligne_frais.utilisateur_id = :IdVisiteur
");
$req->bindParam(':IdVisiteur', $IdVisiteur);
$req->execute();
$frais = $req->fetchAll(PDO::FETCH_ASSOC);

$mois_jour_actuel = date("m-d", strtotime($dateToday));
$req = $pdo->prepare("SELECT DISTINCT DATE_FORMAT(libelle_dates, '%m-%d') AS mois_jour FROM datecloture ORDER BY mois_jour");
$req->execute();
$mois_jour_list = $req->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frais - GSB</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
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
            padding: 0;
            margin: 0;
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

        .dropdown li a {
            display: block;
            padding: 5px 15px;
            color: white;
            text-decoration: none;
        }

        .dropdown li a:hover {
            background-color: #0077cc;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2, h3 {
            color: #098CFF;
        }

        p {
            color: #444;
            font-size: 16px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .styled-table thead {
            background-color: #098CFF;
            color: white;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        .styled-table input[type="button"] {
            padding: 6px 12px;
            border: none;
            background-color: #098CFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .styled-table input[type="button"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
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
<header>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>
            <li class="nav-item"><a href="frais_forfaitaires.php">Saisie Frais</a></li>
            <li><?= $dateToday ?></li>
            <li class="nav-item">
                <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                <ul class="dropdown">
                    <li><a href="index.html">Déconnexion</a></li>
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
