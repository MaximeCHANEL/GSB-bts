<?php
// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb_;charset=utf8', 'root', '');
   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>