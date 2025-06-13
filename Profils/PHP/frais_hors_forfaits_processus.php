<?php
if (isset($_POST['Envoyer'])) { // Le formulaire a été soumis
    // Connexion à la base de données
    // try {
    //     $bdd = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb;charset=utf8', 'root', '');
    // } catch (Exception $e) {
    //     die('Erreur : ' . $e->getMessage());
    // }

    require __DIR__ . '/../Connection_creation_bdd/con_bdd.php'; // Inclusion de la connexion à la BDD

    // Démarrer la session pour récupérer l'IdVisiteur
    session_start();
    if (isset($_SESSION['IdVisiteur'])) {
        $IdVisiteur = $_SESSION['IdVisiteur']; // Récupérer l'ID du visiteur
    } else {
        echo "<script type=\"text/javascript\">window.alert('Utilisateur non connecté.');
        window.location='./Connection/connexion_gsb.html';</script>";
        exit(); // Arrêter le script si l'utilisateur n'est pas connecté
    }

    // Récupération des données du formulaire
    if (!empty($_POST['libelle']) && !empty($_POST['montant']) && !empty($_POST['date']) && !empty($_POST['justification'])) {
        // Les champs du formulaire sont remplis
        $libelle = $_POST['libelle'];
        $montant = $_POST['montant'];
        $date = $_POST['date'];
        $justification = $_POST['justification'];

        // Insertion dans la table lignehorsforfait
        try {
            $req = $bdd->prepare('INSERT INTO lignehorsforfait (Libelle, Montant_unitaire, Date, Justification, IdVisiteur)
            VALUES (?, ?, ?, ?, ?)');
            $req->execute([$libelle, $montant, $date, $justification, $IdVisiteur]);

            // Message de succès et redirection
            echo "<script type=\"text/javascript\">window.alert('Frais hors forfait ajouté avec succès.');
            window.location='index.php';</script>";
        } catch (Exception $e) {
            echo "<script type=\"text/javascript\">window.alert('Erreur lors de l\'ajout des frais hors forfait : " . $e->getMessage() . "');
            window.location='frais_hors_forfaits.php';</script>";
        }
    } else {
        // Afficher une alerte si certains champs sont vides
        echo "<script type=\"text/javascript\">window.alert('Certains champs sont vides.');
        window.location='frais_hors_forfaits.php';</script>";
    }
}
?>