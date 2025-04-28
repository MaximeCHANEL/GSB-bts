<?php
session_start();

// try {
//     // Connexion à la base de données
//     $bdd = new PDO('mysql:host=localhost;dbname=bdd_gsb;charset=utf8', 'root', '');
//     $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (Exception $e) {
//     die('Erreur de connexion : ' . $e->getMessage());
// }

require 'con_bdd.php'; // Inclusion de la connexion à la BDD

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

$mois_actuel = date("m", strtotime($dateToday));
// echo $mois_actuel;

$req = $bdd->prepare("SELECT DISTINCT MONTH(libelle_dates) AS mois FROM datecloture ORDER BY mois");
$req->execute();
$mois_list = $req->fetchAll(PDO::FETCH_COLUMN); // Récupère directement une liste de mois

if ($mois_list) {
    foreach ($mois_list as $mois) {
        if ($mois_actuel == $mois) {
            $req = $bdd->prepare("SELECT DISTINCT MONTH(libelle_dates) AS mois FROM datecloture ORDER BY mois");
            $req->execute();
            $mois_list = $req->fetchAll(PDO::FETCH_COLUMN);
        }
    }
} else {
    echo "Aucun mois trouvé.";
}

// $mois_cloture = date("m", strtotime($date_cloture));
// echo $mois_cloture;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php">GSB</a></li>
                <li class="nav-item"><a href="frais_forfaitaires.php">Frais Forfaitaires</a></li>
                <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste frais</a></li>
                <li>
                    <?php echo $dateToday ?>
                </li>
                <li class="nav-item"><a href="connexion_gsb.html">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2 class="h2"> Formulaire de frais hors forfaits</h2>
        <form name="forins" id="forins" method="post" action="frais_hors_forfaits_processus.php">
            <table>
                <tr>
                    <td><label for="libelle">Libelle :</label></td>
                    <td><input type="text" name="libelle" id="libelle" class="champ" /></td>
                </tr>
                <tr>
                    <td><label for="montant">Montant :</label></td>
                    <td><input type="text" name="montant" id="montant" class="champ" /></td>
                </tr>
                <tr>
                    <td><label for="date">Date :</label></td>
                    <td><input type="date" id="date_hors_forfait" name="date" value="2025-01-10" min="2000-01-01" max="2035-12-31" /></td>
                </tr>
                <tr>
                    <td><label for="justifications">Justifications :</label></td>
                    <td>
                        <textarea id="justification" name="justification" rows="5" cols="33">
                        Ecrire la justification
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="envoi" name="Envoyer" value="Envoyer" /> <input
                            type="reset" id="rafraichir" value="Rafraîchir" /></td>
                </tr>
            </table>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>