<?php

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail']) && isset($_SESSION['dateToday'])) {
    // Récupérer les informations de session
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    // Redirection vers la page de connexion si les variables de session ne sont pas définies
    echo "<script type=\"text/javascript\">window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}

$req = $pdo->prepare('SELECT Libelle_id, Libelle FROM typefrais');
$req->execute();
$frais_libelle = $req->fetchAll(PDO::FETCH_ASSOC);