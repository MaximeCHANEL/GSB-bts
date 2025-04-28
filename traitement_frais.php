<?php
require 'con_bdd.php';

if (!isset($_POST['id_frais']) || !isset($_POST['etat']) || !isset($_POST['id_visiteur'])) {
    die("Erreur : paramètres manquants.");
}

$idFrais = filter_var($_POST['id_frais'], FILTER_VALIDATE_INT);
$idVisiteur = filter_var($_POST['id_visiteur'], FILTER_VALIDATE_INT);
$nouvelEtat = $_POST['etat'];
$motif = isset($_POST['motif']) ? trim($_POST['motif']) : null;

if (!$idFrais || !$idVisiteur) {
    die("Erreur : paramètres invalides.");
}

if ($nouvelEtat == "Refusé" && empty($motif)) {
    echo "<script>alert('Le motif est obligatoire pour un refus.'); window.history.back();</script>";
    exit;
}

// Récupération de l'ID de l'état
$stmt = $pdo->prepare("SELECT id_Etat_frais FROM etatfrais WHERE Etat = :etat");
$stmt->execute(['etat' => $nouvelEtat]);
$etatData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etatData) {
    die("Erreur : État invalide.");
}

$etatId = $etatData['id_Etat_frais'];

// Mise à jour du frais
$req = $pdo->prepare("UPDATE ligne_frais SET Etat_Frais_id = :etat, commentaire = :motif WHERE IdFrais = :idFrais");
$success = $req->execute(['etat' => $etatId, 'motif' => $motif, 'idFrais' => $idFrais]);

if ($success) {
    echo "<script>alert('État du frais mis à jour.'); window.location.href = 'detailfrais.php?id=$idVisiteur&frais_id=$idFrais';</script>";
} else {
    echo "<script>alert('Erreur lors de la mise à jour.'); window.history.back();</script>";
}
?>
