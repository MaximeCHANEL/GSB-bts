<?php
session_start();

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail'])) {
    // Récupérer les informations de session
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
} else {
    // Redirection vers la page de connexion si les variables de session ne sont pas définies
    echo "<script type=\"text/javascript\">window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Accueil</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1>GSB</h1></a></li>
                <li class="nav-item"><a href="frais_forfaitaires.html">Saisies Frais</a></li>
                <li class="nav-item"><a href="./Connection/connexion_gsb.html">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Bienvenue sur l'espace GSB</h2>
        <!-- Affichage des informations de session -->
        <h3>
            BONJOUR <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?> 
            (mail : <?= $mail ?>) 
            (id de l'utilisateur : <?= $IdVisiteur ?>)
        </h3>
        <p>Bienvenue dans votre espace de gestion des frais. Sélectionnez une option dans le menu pour continuer.</p>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>