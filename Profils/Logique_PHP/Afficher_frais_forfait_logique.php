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

$req = $pdo->prepare("
    SELECT ligne_frais.IdFrais, typefrais.libelle AS libelle, 
           ligne_frais.Montant AS montant, ligne_frais.Date AS date, 
           ligne_frais.justificatif AS justificatif, etatfrais.Etat AS etat
    FROM ligne_frais
    INNER JOIN typefrais ON ligne_frais.TypeFrais = typefrais.Libelle_id
    INNER JOIN etatfrais ON ligne_frais.Etat_Frais_id = etatfrais.id_Etat_frais
    WHERE ligne_frais.utilisateur_id = :IdVisiteur
");
$req->bindParam(':IdVisiteur', $IdVisiteur);
$req->execute();
$frais = $req->fetchAll(PDO::FETCH_ASSOC);

$mois_jour_actuel = date("m-d", strtotime($dateToday));
$req = $pdo->prepare("SELECT DISTINCT DATE_FORMAT(libelle_dates, '%m-%d') AS mois_jour FROM datecloture ORDER BY mois_jour");
$req->execute();
$mois_jour_list = $req->fetchAll(PDO::FETCH_COLUMN);