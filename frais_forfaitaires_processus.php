<?php
require 'con_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['justificatif'])) {
    $frais_id = $_POST['frais_id'];
    $file = $_FILES['justificatif'];

    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $max_size = 5 * 1024 * 1024;

    if (!in_array($file['type'], $allowed_types)) {
        die("Format non autorisé !");
    }
    if ($file['size'] > $max_size) {
        die("Fichier trop volumineux !");
    }

    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_name = time() . '_' . basename($file['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $stmt = $pdo->prepare("INSERT INTO justificatifs (frais_id, fichier_nom, fichier_type, fichier_taille, fichier_path) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$frais_id, $file['name'], $file['type'], $file['size'], $file_path]);

        echo "Justificatif envoyé avec succès !";
    } else {
        echo "Erreur lors de l'upload.";
    }
}
?>
