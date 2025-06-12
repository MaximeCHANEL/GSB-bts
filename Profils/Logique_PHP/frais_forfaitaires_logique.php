<?php

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
    echo "<script>window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}

$req = $pdo->prepare('SELECT Libelle_id, Libelle FROM typefrais');
$req->execute();
$frais_libelle = $req->fetchAll(PDO::FETCH_ASSOC);