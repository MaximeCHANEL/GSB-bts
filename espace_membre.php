<?php
session_start();

require 'con_bdd.php';

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail'])) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
} else {
    echo "<script type=\"text/javascript\">window.location='connexion_gsb.html';</script>";
    exit();
}

$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE IdVisiteur = :IdVisiteur");
$req->execute(['IdVisiteur' => $IdVisiteur]);
$utilisateurs = $req->fetch(PDO::FETCH_ASSOC);

if (!$utilisateurs) {
    die("Aucun utilisateur trouvé.");
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
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
            padding-left: 0;
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
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #098CFF;
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-top: 10px;
        }

        footer {
            text-align: center;
            background-color: #f1f1f1;
            padding: 20px;
            margin-top: 50px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>

                <?php if ($_SESSION['role_id'] == 3): ?>
                    <li class="nav-item"><a href="frais_forfaitaires.php">Saisies Frais</a></li>
                    <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste frais</a></li>
                <?php elseif ($_SESSION['role_id'] == 1): ?>
                    <li class="nav-item"><a href="admin.php">Liste Utilisateurs</a></li>
                <?php elseif ($_SESSION['role_id'] == 2): ?>
                    <li class="nav-item"><a href="dashbord.php">Comptable</a></li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="espace_membre.php">
                        Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?>
                    </a>
                    <ul class="dropdown">
                        <li><a href="index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Bienvenue sur l'espace GSB</h2>
        <h3>
            Bonjour <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?> <br>
            (Mail : <?= htmlspecialchars($mail) ?>) <br>
            (ID utilisateur : <?= $IdVisiteur ?>)
        </h3>
        <p>Bienvenue dans votre espace personnel. Utilisez la barre de navigation pour gérer vos frais ou accéder à vos fonctionnalités selon votre rôle.</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
