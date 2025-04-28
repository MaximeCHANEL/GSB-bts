<?php

session_start();

if (isset($_SESSION['IdVisiteur']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mail']) && isset($_SESSION['dateToday'])) {
    // Récupérer les informations de session
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    // Redirection vers la page de connexion si les variables de session ne sont pas définies
    echo "<script type=\"text/javascript\">window.location='connexion_gsb.html';</script>";
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['Envoyer'])) {
    // try {
    //     // Connexion à la base de données
    //     $bdd = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb;charset=utf8', 'root', '');
    //     $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch (Exception $e) {
    //     die('Erreur : ' . $e->getMessage());
    // }

    require 'con_bdd.php'; // Inclusion de la connexion à la BDD

    // Vérification que tous les champs sont remplis
    if (!empty($_POST['libelle']) && !empty($_POST['montant']) && !empty($_POST['date'])) {
        // Récupération des données du formulaire
        $libelle = (int) $_POST['libelle'];
        $montant = floatval($_POST['montant']); // Convertir en float
        $date = $_POST['date'];
        $etatFraisId = 2; // Valeur de l'état des frais

        // Insertion dans la table fraisforfait
        $req = $pdo->prepare('INSERT INTO ligne_frais(TypeFrais, Montant, Date, utilisateur_id, Etat_Frais_id) VALUES(?, ?, ?, ?, ?)');
        $req->execute([$libelle, $montant, $date, $IdVisiteur, $etatFraisId]);

        // Récupération de l'ID inséré
        $lastId = $pdo->lastInsertId();

        // Initialisation de la session
        $_SESSION["IdFrais"] = $lastId;
        $_SESSION["libelle"] = $libelle;
        $_SESSION["montant"] = $montant;
        $_SESSION["date"] = $date;

        // Redirection avec un message de succès
        echo "<script>alert('Frais ajouté avec succès'); window.location='Afficher_frais_forfait.php';</script>";
    } else {
        echo "<script>alert('Certains champs sont vides'); window.location='frais_forfaitaires.php';</script>";
    }
}

?>
