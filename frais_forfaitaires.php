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

$req = $pdo->prepare('SELECT Libelle_id, Libelle FROM typefrais');
$req->execute();
$frais_libelle = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Frais Forfaitaires - GSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #098CFF;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 12px 8px;
            vertical-align: middle;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], select, input[type="date"], input[type="file"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .montant {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        input[type="submit"], input[type="reset"] {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 16px;
            cursor: pointer;
        }

        #envoi {
            background-color: #098CFF;
            color: white;
        }

        #rafraichir {
            background-color: #ccc;
            color: #333;
            margin-left: 10px;
        }

        input[type="submit"]:hover {
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
<header>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>
            <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste Frais</a></li>
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
    <h2>Formulaire de frais forfaitaires</h2>
    <form name="forins" id="forins" method="post" action="frais_forfaitaires_processuss.php" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="libelle">Libellé :</label></td>
                <td>
                    <select name="libelle" id="type_frais" required>
                        <option value="">-- Veuillez choisir un type --</option>
                        <?php foreach ($frais_libelle as $libelle): ?>
                            <option value="<?= htmlspecialchars($libelle['Libelle_id']) ?>">
                                <?= htmlspecialchars($libelle['Libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="montant">Montant (€) :</label></td>
                <td>
                    <input type="text" name="montant" id="montant" required />
                    <p class="montant">Montant max : 300€. Au-delà, veuillez choisir "Autre" pour un frais hors forfait.</p>
                </td>
            </tr>
            <tr>
                <td><label for="date">Date :</label></td>
                <td><input type="date" name="date" id="date_hors_forfait" value="<?= $dateToday ?>" min="2000-01-01" max="2035-12-31" required /></td>
            </tr>
            <tr id="justificatifRow" style="display:none;">
                <td><label for="justificatif">Justificatif :</label></td>
                <td><input type="file" name="justificatif" accept=".pdf, .jpg, .jpeg, .png"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="submit" id="envoi" name="Envoyer" value="Envoyer">
                    <input type="reset" id="rafraichir" value="Rafraîchir">
                </td>
            </tr>
        </table>
    </form>
</div>

<footer>
    <p>&copy; 2024 GSB. Tous droits réservés.</p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectType = document.getElementById("type_frais");
        const justificatifRow = document.getElementById("justificatifRow");

        selectType.addEventListener("change", function () {
            justificatifRow.style.display = this.value === "4" ? "table-row" : "none";
        });
    });
</script>
</body>
</html>
