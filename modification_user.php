<?php
session_start();

require 'con_bdd.php';

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['ville']) && isset($_SESSION['mail']) && isset($_SESSION['matricule'])  && isset($_SESSION['dateToday'])) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $matricule = htmlspecialchars($_SESSION['matricule']);
    $ville = htmlspecialchars($_SESSION['ville']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    echo "<script type=\"text/javascript\">window.location='connexion_gsb.html';</script>";
    exit();
}

$IdVisiteur = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($IdVisiteur == 0) {
    die("Erreur : ID invalide.");
}

$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE IdVisiteur = :IdVisiteur");
$req->execute(['IdVisiteur' => $IdVisiteur]);
$utilisateurs = $req->fetch(PDO::FETCH_ASSOC);

if (!$utilisateurs) {
    die("Aucun utilisateur trouvé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['matricule']) && !empty($_POST['ville']) && !empty($_POST['mail'])) {
        $nom = (string) $_POST['nom'];
        $prenom = (string) $_POST['prenom'];
        $matricule = (string) $_POST['matricule'];
        $ville = (string) $_POST['ville'];
        $mail = (string) $_POST['mail'];

        $reqUpdate = $pdo->prepare("UPDATE utilisateurs 
        SET nom = ?, matricule = ?, prenom = ?, ville = ?, mail = ?
        WHERE IdVisiteur = ?");
        $reqUpdate->execute([$nom, $matricule, $prenom, $ville, $mail, $IdVisiteur]);

        $_SESSION["nom"] = $nom;
        $_SESSION["prenom"] = $prenom;
        $_SESSION["matricule"] = $matricule;
        $_SESSION["ville"] = $ville;
        $_SESSION["mail"] = $mail;

        echo "<script>alert('Utilisateur mis à jour avec succès !'); window.location='admin.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #098CFF;
            padding: 15px;
            color: white;
        }

        .nav-list {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .container {
            max-width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #098CFF;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 95%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #098CFF;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"]:hover {
            background-color: #0077cc;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #555;
            background-color: #f1f1f1;
            margin-top: 50px;
        }

        .dropdown {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #098CFF;
        }

        .dropdown li a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            display: block;
        }

        .dropdown li a:hover {
            background-color: #0077cc;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>
                <li style="color: white; font-weight: bold;"><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($_SESSION['nom']) ?> <?= ucfirst($_SESSION['prenom']) ?></a>
                    <ul class="dropdown">
                        <li><a href="index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Modifier un utilisateur</h2>
        <form method="post">
            <table>
                <tr>
                    <td><label for="nom">Nom :</label></td>
                    <td><input type="text" name="nom" id="nom" value="<?= htmlspecialchars($utilisateurs['Nom']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="prenom">Prénom :</label></td>
                    <td><input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($utilisateurs['Prenom']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="matricule">Matricule :</label></td>
                    <td><input type="text" name="matricule" id="matricule" value="<?= htmlspecialchars($utilisateurs['Matricule']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="ville">Ville :</label></td>
                    <td><input type="text" name="ville" id="ville" value="<?= htmlspecialchars($utilisateurs['Ville']) ?>"></td>
                </tr>
                <tr>
                    <td><label for="mail">Mail :</label></td>
                    <td><input type="text" name="mail" id="mail" value="<?= htmlspecialchars($utilisateurs['Mail']) ?>"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Mettre à jour"></td>
                </tr>
            </table>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
