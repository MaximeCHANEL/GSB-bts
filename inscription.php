<?php

if (isset($_POST['Envoyer'])) {
    // try {
    //     $bdd = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb;charset=utf8', 'root', '');
    // } catch (Exception $e) {
    //     die('Erreur : ' . $e->getMessage());
    // }

    require 'con_bdd.php'; // Inclusion de la connexion à la BDD

    if (!empty($_POST['pseudonyme']) && !empty($_POST['mdp']) && !empty($_POST['confirmation']) && !empty($_POST['email']) && $_POST['confirmation'] == $_POST['mdp']){

        $pseudonyme = $_POST['pseudonyme'];
        $pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        $req = $bdd->prepare('INSERT INTO utilisateurs(nom,prenom,email,mot_de_passe)
        VALUES(?, ?, ?, ?)');
        $req->execute([$pseudonyme,$nom,$email, $pass_hache]);
    }
}