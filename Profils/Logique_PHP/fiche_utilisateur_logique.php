<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'utilisateur non spécifié.");
}

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

$idVisiteur = $_GET['id'];

$sql = "SELECT 
        utilisateurs.Nom, 
        utilisateurs.Prenom,
        ligne_frais.IdFrais, 
        ligne_frais.Date, 
        etatfrais.Etat, 
        ligne_frais.Montant, 
        TypeFrais.Libelle AS TypeFrais
        FROM ligne_frais
        JOIN utilisateurs ON ligne_frais.utilisateur_id = utilisateurs.IdVisiteur 
        JOIN etatfrais ON ligne_frais.Etat_Frais_id = etatfrais.id_Etat_frais
        JOIN TypeFrais ON ligne_frais.TypeFrais = TypeFrais.Libelle_id
        WHERE ligne_frais.utilisateur_id = :id 
        ORDER BY ligne_frais.Date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idVisiteur]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$notes) {
    die("Aucun frais trouvé pour cet utilisateur.");
}