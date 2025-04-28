<?php
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Membre</title>
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
            list-style-type: none;
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
            max-width: 700px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #098CFF;
            margin-bottom: 15px;
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-weight: bold;
            color: #0077cc;
            font-size: 18px;
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
        <h2>Bienvenue sur l'espace membre GSB</h2>
        <h3>
            Bonjour <strong><?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></strong><br>
            <small>(mail : <?= $mail ?>)</small><br>
            <small>(ID utilisateur : <?= $IdVisiteur ?>)</small>
        </h3>
        <p>Rôle : Visiteur Médical</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
