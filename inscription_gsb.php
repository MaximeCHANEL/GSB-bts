<?php
session_start();
require 'con_bdd.php';

if (isset($_POST['Envoyer'])) {
    if (
        !empty($_POST['matricule']) && !empty($_POST['nom']) && !empty($_POST['prenom']) &&
        !empty($_POST['ville']) && !empty($_POST['mail']) && !empty($_POST['mdp']) &&
        $_POST['mdp'] == $_POST['cmdp']
    ) {
        $matricule = $_POST['matricule'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $ville = $_POST['ville'];
        $mail = $_POST['mail'];
        $pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $role_id = 3; // Visiteur médical

        // Vérifier si le rôle existe
        $check = $pdo->prepare('SELECT COUNT(*) FROM roles WHERE id = ?');
        $check->execute([$role_id]);
        if ($check->fetchColumn() == 0) {
            echo "<script>alert('Rôle invalide'); window.location='inscription_gsb.html';</script>";
            exit();
        }

        // Insérer l'utilisateur
        $req = $pdo->prepare('INSERT INTO utilisateurs (matricule, nom, prenom, ville, mail, mot_de_passe, role_id)
                              VALUES (?, ?, ?, ?, ?, ?, ?)');
        $req->execute([$matricule, $nom, $prenom, $ville, $mail, $pass_hache, $role_id]);

        echo "<script>alert('Compte utilisateur ajouté avec succès'); window.location='admin.php';</script>";
        exit();
    } else {
        echo "<script>alert('Champs incomplets ou mots de passe non identiques'); window.location='inscription_gsb.html';</script>";
        exit();
    }
}

// Vérification des variables de session
if (
    isset($_SESSION['IdVisiteur'], $_SESSION['nom'], $_SESSION['prenom'], $_SESSION['mail'],
          $_SESSION['matricule'], $_SESSION['ville'], $_SESSION['dateToday'])
) {
    $IdVisiteur = htmlspecialchars($_SESSION['IdVisiteur']);
    $nom = htmlspecialchars($_SESSION['nom']);
    $prenom = htmlspecialchars($_SESSION['prenom']);
    $mail = htmlspecialchars($_SESSION['mail']);
    $matricule = htmlspecialchars($_SESSION['matricule']);
    $ville = htmlspecialchars($_SESSION['ville']);
    $dateToday = htmlspecialchars($_SESSION['dateToday']);
} else {
    echo "<script>window.location='connexion_gsb.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
        }

        nav {
            background-color: #098CFF;
            padding: 15px;
            color: white;
        }

        .nav-list {
            list-style-type: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            font-size: 18px;
        }

        .nav-item a:hover {
            background-color: #0077cc;
            border-radius: 5px;
        }

        .dropdown {
            list-style: none;
            background-color: #098CFF;
            margin-top: 5px;
        }

        .dropdown li a {
            display: block;
            padding: 5px 15px;
            color: white;
            text-decoration: none;
        }

        .dropdown li a:hover {
            background-color: #0077cc;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #098CFF;
            margin-bottom: 25px;
            text-align: center;
        }

        table {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"], input[type="reset"] {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #098CFF;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #0077cc;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            margin-top: 50px;
            color: #777;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php"><h1 style="margin: 0;">GSB</h1></a></li>
                <li><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <ul class="dropdown">
                        <li><a href="index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Formulaire d'inscription</h2>
        <form name="forins" method="post">
            <label for="matricule">Matricule</label>
            <input type="text" name="matricule" id="matricule" required />

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required />

            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" required />

            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" required />

            <label for="mail">E-mail</label>
            <input type="text" name="mail" id="mail" required />

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" required />

            <label for="cmdp">Confirmer le mot de passe</label>
            <input type="password" name="cmdp" id="cmdp" required />

            <input type="submit" name="Envoyer" value="Envoyer" />
            <input type="reset" value="Rafraîchir" />
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>
