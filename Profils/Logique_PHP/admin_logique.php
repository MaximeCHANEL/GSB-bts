<?php if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail']) && isset($_SESSION['matricule']) && isset($_SESSION['ville']) && isset($_SESSION['dateToday'])) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $matricule = htmlspecialchars($_SESSION['matricule']);
    $ville = htmlspecialchars($_SESSION['ville']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    echo "<script type=\"text/javascript\">window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}

$req = $pdo->prepare("SELECT IdVisiteur, Nom, Prenom, Matricule, Ville, Mail FROM utilisateurs");
$req->execute();
$users = $req->fetchAll(PDO::FETCH_ASSOC);