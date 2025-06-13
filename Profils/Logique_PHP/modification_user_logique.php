<?php

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['ville']) && isset($_SESSION['mail']) && isset($_SESSION['matricule'])  && isset($_SESSION['dateToday'])) {
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

$IdVisiteur = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($IdVisiteur == 0) {
    die("Erreur : ID invalide.");
}

$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE IdVisiteur = :IdVisiteur");
$req->execute(['IdVisiteur' => $IdVisiteur]);
$utilisateurs = $req->fetch(PDO::FETCH_ASSOC);

if (!$utilisateurs) {
    die("Aucun utilisateur trouvé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['matricule']) && !empty($_POST['ville']) && !empty($_POST['mail'])) {
        $nom = (string) $_POST['nom'];
        $prenom = (string) $_POST['prenom'];
        $matricule = (string) $_POST['matricule'];
        $ville = (string) $_POST['ville'];
        $mail = (string) $_POST['mail'];

        $reqUpdate = $pdo->prepare("UPDATE utilisateurs 
        SET nom = ?, matricule = ?, prenom = ?, ville = ?, mail = ?
        WHERE IdVisiteur = ?");
        $reqUpdate->execute([$nom, $matricule, $prenom, $ville, $mail, $IdVisiteur]);

        $_SESSION["nom"] = $nom;
        $_SESSION["prenom"] = $prenom;
        $_SESSION["matricule"] = $matricule;
        $_SESSION["ville"] = $ville;
        $_SESSION["mail"] = $mail;

        echo "<script>alert('Utilisateur mis à jour avec succès !'); window.location='admin.php';</script>";
        exit();
    } else {
        echo "<script>alert('Tous les champs doivent être remplis !');</script>";
    }
}