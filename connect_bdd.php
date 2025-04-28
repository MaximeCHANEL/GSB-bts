<?php
$servername = "sql100.infinityfree.com";  // Adresse IP ou domaine de ton serveur
$username = "if0_38537404";              // Ton nom d'utilisateur
$password = "6v4R5bAFZqJyDhA";           // Ton mot de passe
$dbname = "if0_38537404_db_gsb";         // Nom de la base de données

try {
    // Créer la connexion PDO avec le port spécifié
    $bdd = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $username, $password);
    
    // Définir le mode d'erreur de PDO pour afficher les erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion réussie !";
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Échec de la connexion : " . $e->getMessage());
}
?>