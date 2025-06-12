<?php

if (!isset($_GET['id']) || !isset($_GET['frais_id'])) {
    die("Paramètres manquants.");
}

$idVisiteur = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$idFrais = filter_var($_GET['frais_id'], FILTER_VALIDATE_INT);

if (!$idVisiteur || !$idFrais) {
    die("Paramètres invalides.");
}

try {
    $sql = "SELECT 
                u.Nom, 
                u.Prenom, 
                lf.Date, 
                lf.Montant, 
                ef.Etat,
                tf.Libelle,
                lf.Justificatif
            FROM ligne_frais lf
            JOIN utilisateurs u ON lf.utilisateur_id = u.IdVisiteur 
            JOIN typefrais tf ON lf.TypeFrais = tf.Libelle_id
            JOIN etatfrais ef ON lf.Etat_Frais_id = ef.id_Etat_frais
            WHERE lf.IdFrais = :idFrais AND lf.utilisateur_id = :idVisiteur";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idFrais' => $idFrais, 'idVisiteur' => $idVisiteur]);
    $frais = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$frais) {
        die("Aucun détail trouvé pour ce frais.");
    }
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}