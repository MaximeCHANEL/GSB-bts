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

$mois_actuel = date("m", strtotime($dateToday));
// echo $mois_actuel;

$req = $bdd->prepare("SELECT DISTINCT MONTH(libelle_dates) AS mois FROM datecloture ORDER BY mois");
$req->execute();
$mois_list = $req->fetchAll(PDO::FETCH_COLUMN); // Récupère directement une liste de mois

if ($mois_list) {
    foreach ($mois_list as $mois) {
        if ($mois_actuel == $mois) {
            $req = $bdd->prepare("SELECT DISTINCT MONTH(libelle_dates) AS mois FROM datecloture ORDER BY mois");
            $req->execute();
            $mois_list = $req->fetchAll(PDO::FETCH_COLUMN);
        }
    }
} else {
    echo "Aucun mois trouvé.";
}

// $mois_cloture = date("m", strtotime($date_cloture));
// echo $mois_cloture;