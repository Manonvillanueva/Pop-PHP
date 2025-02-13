<?php
// Démarre une session PHP pour pouvoir accéder aux informations de session
session_start();

// Connexion à la BDD 
$con = mysqli_connect("db", "root", "example", "pop_php");
// Si échec de co à la BDD 
if (!$con) {
    echo json_encode(["success" => false, "message" => "Une erreur est survenue. Veuillez réessayer plus tard."]);
    exit();
}

// Vérifie si l'ID du produit (articles_id) a été fourni dans les données POST
if (!isset($_POST['articles_id'])) {
    echo json_encode(["success" => false, "message" => "Une erreur est survenue. Veuillez réessayer plus tard."]);
    exit();
}

// Récupère l'ID du produit envoyé par le client via la requête POST.
$productId = $_POST['articles_id'];
// Récupère l'ID de l'utilisateur depuis la session.
$userId = $_SESSION["user_id"];

// Si l'utilisateur n'est pas connecté
if (!$userId) {
    echo json_encode(["success" => false, "message" => "Utilisateur non connecté."]);
    exit();
}

// Prépare la requête SQL pour insérer un produit dans le panier de l'utilisateur. 
// Si le produit existe déjà, la quantité est mise à jour (ajoutée de 1).
$card_bdd =  "INSERT INTO panier (user_id, articles_id, quantite) VALUES (?, ?, 1) 
              ON DUPLICATE KEY UPDATE quantite = quantite + 1";

$query_card = mysqli_prepare($con, $card_bdd);

// Si la préparation de la requête échoue
if ($query_card === false) {
    echo json_encode(["success" => false, "message" => "Requête SQL : " . $card_bdd]);
    exit();
}

// Lie les paramètres à la requête SQL préparée. Ici, l'ID de l'utilisateur et l'ID du produit sont passés.
mysqli_stmt_bind_param($query_card, "ii", $userId, $productId);
// Exécute la requête préparée pour insérer ou mettre à jour le panier dans la base de données.
$executeResult = mysqli_stmt_execute($query_card);

if ($executeResult) {
    echo json_encode(["success" => true, "message" => "Produit ajouté au panier."]);
} else {
    echo json_encode(["success" => false, "message" => "Une erreur est survenue. Veuillez réessayer plus tard."]);
}

// Fermeture de la requête 
mysqli_stmt_close($query_card);
// Fermeture de la co à la BDD 
mysqli_close($con);
