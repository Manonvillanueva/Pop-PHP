<?php
// Démarrer la session au tout début
session_start();

// Vérifie si la session est déjà démarrée
if (isset($_SESSION['email'])) {
    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();
}

// Redirection
header("Location: ../index.php");
// Mettre exit juste après une redirection 
exit();
