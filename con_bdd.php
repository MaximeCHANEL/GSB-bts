<?php
// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=maximek100.mysql.db;dbname=maximek100;charset=utf8', 'maximek100', 'GsbBTS25');    /* $pdo = new PDO('mysql:host=localhost:3306;dbname=bdd_gsb_;charset=utf8', 'root', '');  */
   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>