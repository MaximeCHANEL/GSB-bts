<?php
session_start();
require __DIR__ . '/../Connection_creation_bdd/con_bdd.php';

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

        echo "<script>alert('Compte utilisateur ajouté avec succès'); window.location='/../Connection/connexion_gsb.html';</script>";
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
    echo "<script>window.location='./Connection/connexion_gsb.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../assets/styles.css">
    <title>Inscription</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="/../Profils/PHP/espace_membre.php"><h1>GSB</h1></a></li>
                <li><?= $dateToday ?></li>
                <li class="nav-item">
                    <a href="/../Profils/PHP/espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <ul class="dropdown">
                        <li><a href="/../index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="containerModifUser" id="inscription-container">
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
