<?php

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail'])) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
} else {
    echo "<script type=\"text/javascript\">window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}

$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE IdVisiteur = :IdVisiteur");
$req->execute(['IdVisiteur' => $IdVisiteur]);
$utilisateurs = $req->fetch(PDO::FETCH_ASSOC);

if (!$utilisateurs) {
    die("Aucun utilisateur trouvé.");
}