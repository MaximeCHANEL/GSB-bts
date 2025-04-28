<?php
if (isset($_POST['Envoyer'])) {

    // création de l'objet PDO
    // Connexion à la base de données

    // try {
    //     $bdd = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb;charset=utf8', 'root', '');
    // } catch (Exception $e) {
    //     die('Erreur : ' . $e->getMessage());
    // }

    require 'con_bdd.php'; // Inclusion de la connexion à la BDD

    // include_once 'config.php'; require_once 'config.php';     
    // Récupération des données du formulaire

    $email = $_POST['mail'];

    $dateToday = date("Y-m-d");

    $req = $pdo->prepare('SELECT IdVisiteur,nom,prenom,mot_de_passe,mail, matricule, ville, role_id FROM  utilisateurs
    where mail=?');

    $req->execute(array($email));

    $reponse = $req->fetch();

    $compare = password_verify($_POST['mdp'], $reponse['mot_de_passe']);

    if ($compare) {  // Cas où les données de connexion sont trouvées dans la table utilisateurs
        $role_id = $reponse['role_id'];

        session_start();
        //Ecriture des variables des sessions
        $_SESSION["IdVisiteur"] = $reponse['IdVisiteur'];
        $_SESSION["nom"] = $reponse['nom'];
        $_SESSION["prenom"] = $reponse['prenom'];
        $_SESSION["mail"] = $reponse['mail'];
        $_SESSION["matricule"] = $reponse['matricule'];
        $_SESSION["ville"] = $reponse['ville'];
        $_SESSION["role_id"] = $role_id;
        $_SESSION["dateToday"] = $dateToday;
        
        // Redirection en fonction du rôle
        if ($role_id == 3) {
            echo "<script type=\"text/javascript\"> window.location='visiteur_medical.php' </script>";
        } elseif ($role_id == 2) {
            echo "<script type=\"text/javascript\"> window.location='dashbord.php' </script>";
        }elseif ($role_id == 1) {
            echo "<script type=\"text/javascript\"> window.location='admin.php' </script>";
        }else {
            echo "<script type=\"text/javascript\">window.alert ('Rôle non autorisé'); window.location='connexion_gsb.html' </script>";
        }
    } else {
        // Message d'erreur en cas d'identifiants incorrects
        echo "<script type=\"text/javascript\">window.alert ('Les identifiants sont incorrects'); window.location='connexion_gsb.html' </script>";
    }
}