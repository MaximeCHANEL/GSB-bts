<?php
session_start();
require 'con_bdd.php';

$IdFrais = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($IdFrais === 0) {
    die("Erreur : ID invalide.");
}

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

$req = $pdo->prepare("SELECT * FROM ligne_frais WHERE IdFrais = :id");
$req->execute(['id' => $IdFrais]);
$frais = $req->fetch(PDO::FETCH_ASSOC);
if (!$frais) {
    die("Aucun frais trouvé.");
}

$reqLibelle = $pdo->query("SELECT Libelle_id, Libelle FROM typefrais");
$frais_libelle = $reqLibelle->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['libelle']) && !empty($_POST['montant']) && !empty($_POST['date'])) {
        $libelle = (int) $_POST['libelle'];
        $montant = floatval($_POST['montant']);
        $date = $_POST['date'];

        $reqUpdate = $pdo->prepare("UPDATE ligne_frais 
                                    SET TypeFrais = ?, Montant = ?, Date = ?
                                    WHERE IdFrais = ?");
        $reqUpdate->execute([$libelle, $montant, $date, $IdFrais]);

        $_SESSION["libelle"] = $libelle;
        $_SESSION["montant"] = $montant;
        $_SESSION["date"] = $date;

        echo "<script>alert('Frais mis à jour avec succès !'); window.location='Afficher_frais_forfait.php';</script>";
        exit();
    } else {
        echo "<script>alert('Tous les champs doivent être remplis !');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un frais - GSB</title>
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

        input[type="text"], select, input[type="date"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 16px;
            cursor: pointer;
            background-color: #098CFF;
            color: white;
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

<section>
    <div class="container">
        <h2>Modifier un frais</h2>
        <form method="post">
            <table>
                <tr>
                    <td><label for="libelle">Libellé :</label></td>
                    <td>
                        <select name="libelle" id="type_frais" required>
                            <?php foreach ($frais_libelle as $libelle): ?>
                                <option value="<?= $libelle['Libelle_id'] ?>"
                                    <?= ($libelle['Libelle_id'] == $frais['TypeFrais']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($libelle['Libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="montant">Montant (€) :</label></td>
                    <td><input type="text" name="montant" value="<?= htmlspecialchars($frais['Montant']) ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="date">Date :</label></td>
                    <td><input type="date" name="date" value="<?= htmlspecialchars($frais['Date']) ?>" min="2000-01-01" max="2035-12-31" required /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        <input type="submit" name="Envoyer" value="Mettre à jour" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>

<footer>
    <p>&copy; 2024 GSB. Tous droits réservés.</p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectType = document.getElementById("type_frais");
        const justificationRow = document.querySelector(".justification");

        if (justificationRow) justificationRow.style.display = "none";

        selectType.addEventListener("change", function () {
            if (justificationRow) {
                justificationRow.style.display = this.value === "4" ? "table-row" : "none";
            }
        });
    });
</script>
</body>
</html>
