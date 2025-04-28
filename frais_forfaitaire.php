<?php
session_start();

// Connexion à la base de données
// try {
//     $bdd = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb;charset=utf8', 'root', '');
// } catch (Exception $e) {
//     die('Erreur : ' . $e->getMessage());
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

$req = $pdo->prepare('SELECT Libelle_id, Libelle FROM typefrais');
$req->execute();
$frais_libelle = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Frais Forfaitaires</title>
</head>
<body>
<header>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="espace_membre.php">
                        <h1 style="margin: 0; color: white;">GSB</h1>
                    </a>
                </li>
                <li class="nav-item"><a href="Afficher_frais_forfait.php">Liste frais</a></li>
                <li>
                    <?php echo $dateToday ?>
                </li>
                <li class="nav-item">
                    <a href="espace_membre.php">Bienvenue <?= ucfirst($nom) ?> <?= ucfirst($prenom) ?></a>
                    <!-- Menu déroulant -->
                    <ul class="dropdown">
                        <li><a href="index.html">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2 class="h2"> Formulaire de frais forfaitaires</h2>
        <form name="forins" id="forins" method="post" action="frais_forfaitaires_processus.php">
            <table>
                <tr>
                    <td><label for="libelle">Libelle :</label></td>
                    <td>
                        <select name="libelle" id="type_frais">
                            <option value="">--Please choose an option--</option>
                            <?php foreach ($frais_libelle as $libelle): ?>
                                <option value="<?= htmlspecialchars($libelle['Libelle_id']) ?>"><?= htmlspecialchars($libelle['Libelle']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="montant">Montant :</label></td>
                    <td>
                        <input type="text" name="montant" id="montant" class="champ" />
                        <p class="montant">Montant maximum : 300€. Si cela dépasse veuillez cliquer sur autre à côté du libelle pour un frais hors forfait</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="date">Date :</label></td>
                    <td><input type="date" id="date_hors_forfait" name="date" value="2025-01-10" min="2000-01-01" max="2035-12-31" /></td>
                </tr>
                <tr class="justification" style="display: none">
                    <td><label for="fileUpload">Choisissez un fichier :</label>
                    <td colspan="2"><input type="file" name="justificatif" id="fileUpload" required /></td></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="envoi" name="Envoyer" value="Envoyer" />
                    <input type="reset" id="rafraichir" value="Rafraîchir" /></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        document.getElementById("type_frais").addEventListener("change", function () {
            let justificatif = document.querySelector(".justification"); // Sélectionne le bloc
            if (this.value === "4") { // Vérifie si la valeur sélectionnée est "Autre"
                justificatif.style.display = "block"; // Affiche le bloc
            } else {
                justificatif.style.display = "none"; // Cache le bloc si un autre choix est sélectionné
            }
        });
    </script>


    <footer>
        <p>&copy; 2024 GSB. Tous droits réservés.</p>
    </footer>
</body>
</html>