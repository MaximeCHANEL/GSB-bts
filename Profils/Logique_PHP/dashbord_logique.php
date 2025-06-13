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

// Requête pour récupérer les visiteurs et leurs frais
$sql = "SELECT 
            Nom, 
            Prenom,
            IdVisiteur,
            COUNT(hf.IdFrais) AS nbFrais
        FROM utilisateurs
        INNER JOIN ligne_frais hf ON IdVisiteur = utilisateur_id
        GROUP BY IdVisiteur";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$visiteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);