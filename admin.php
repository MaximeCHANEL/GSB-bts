<?php
session_start();

require 'con_bdd.php'; // Inclusion de la connexion à la BDD

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail']) && isset($_SESSION['matricule']) && isset($_SESSION['ville']) && isset($_SESSION['dateToday'])) {
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

$req = $pdo->prepare("SELECT IdVisiteur, Nom, Prenom, Matricule, Ville, Mail FROM utilisateurs");
$req->execute();
$users = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Membre</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        nav { background-color: #098CFF; color: white; padding: 15px; }
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
            font-size: 18px;
            padding: 10px 15px;
        }
        .nav-item a:hover {
            background-color: #0077cc;
            border-radius: 5px;
        }
        .nav-item h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            max-width: 90%;
            margin: 40px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .styled-table th {
            background-color: #f4f4f4;
        }

        input[type="button"], input[type="submit"] {
            background-color: #098CFF;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="button"]:hover, input[type="submit"]:hover {
            background-color: #0077cc;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            color: #555;
            background-color: #f1f1f1;
            margin-top: 40px;
        }

        .dropdown {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #098CFF;
        }

        .dropdown li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
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
                <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
                <li style="color: white; font-weight: bold;"><?= $dateToday ?></li>
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
        <h2 style="text-align: center; color: #098CFF;">Liste des utilisateurs</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Matricule</th>
                    <th>Ville</th>
                    <th>Mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= ucfirst($user['Nom']) ?></td>
                        <td><?= $user['Prenom'] ?></td>
                        <td><?= $user['Matricule'] ?></td>
                        <td><?= $user['Ville'] ?></td>
                        <td><?= $user['Mail'] ?></td>
                        <td>
                            <input type="button" value="Modifier" onclick="window.location.href='modification_user.php?id=<?= $user['IdVisiteur'] ?>';">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="inscription_gsb.php" style="text-align: center;">
            <input type="submit" name="new_user" value="Ajouter un utilisateur">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
