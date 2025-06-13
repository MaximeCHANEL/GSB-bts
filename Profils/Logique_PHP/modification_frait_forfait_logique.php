<?php

$IdFrais = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($IdFrais === 0) {
    die("Erreur : ID invalide.");
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

$req = $pdo->prepare("SELECT * FROM ligne_frais WHERE IdFrais = :id");
$req->execute(['id' => $IdFrais]);
$frais = $req->fetch(PDO::FETCH_ASSOC);
if (!$frais) {
    die("Aucun frais trouvé.");
}

$reqLibelle = $pdo->query("SELECT Libelle_id, Libelle FROM typefrais");
$frais_libelle = $reqLibelle->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['libelle']) && !empty($_POST['montant']) && !empty($_POST['date'])) {
        $libelle = (int) $_POST['libelle'];
        $montant = floatval($_POST['montant']);
        $date = $_POST['date'];

        $reqUpdate = $pdo->prepare("UPDATE ligne_frais 
                                    SET TypeFrais = ?, Montant = ?, Date = ?
                                    WHERE IdFrais = ?");
        $reqUpdate->execute([$libelle, $montant, $date, $IdFrais]);

        $_SESSION["libelle"] = $libelle;
        $_SESSION["montant"] = $montant;
        $_SESSION["date"] = $date;

        echo "<script>alert('Frais mis à jour avec succès !'); window.location='Afficher_frais_forfait.php';</script>";
        exit();
    } else {
        echo "<script>alert('Tous les champs doivent être remplis !');</script>";
    }
}