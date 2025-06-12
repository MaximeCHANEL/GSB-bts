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

$sql = "SELECT fiche_frais.id_FicheFrais AS id_FicheFrais, fiche_frais.nbJustificatifs AS nbJustificatifs, fiche_frais.montantValide AS montantValide, fiche_frais.dateModif AS dateModif, fiche_frais.idVisiteur AS idVisiteur, utilisateurs.Prenom AS prenom
        FROM fiche_frais
        INNER JOIN utilisateurs ON fiche_frais.idVisiteur = utilisateurs.IdVisiteur
        WHERE fiche_frais.idVisiteur = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idVisiteur]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$notes) {
    die("Aucun frais trouvé pour cet utilisateur.");
}