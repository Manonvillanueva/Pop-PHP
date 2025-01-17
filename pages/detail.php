<?php
// AJOUT DU HEADER 
include "../includes/header.php";

// MAIN
// Récupération de l'ID depuis l'URL
$id = $_GET["id"];
// Connexion à la BDD 
$con = mysqli_connect("db", "root", "example", "pop_php");
// Vérification si la connexion a réussi
if (!$con) {
    die("Connexion échouée : " . mysqli_connect_error());
} else {
    // Exécution de la requête SQL pour récupérer les informations du produit correspondant à l'ID
    $req_id = mysqli_query($con, "SELECT * FROM articles WHERE id = '$id'");
    // Vérification si un produit correspondant a été trouvé
    if (mysqli_num_rows($req_id) == 0) {
        echo '<div class="detail-container">
        <p>Produit non trouvé ...</p>
        </div>';
    } else {
        // Si un produit est trouvé, récupérer les données du produit
        $assoc_id = mysqli_fetch_assoc($req_id);
        // Affichage des détails du produit dans une structure HTML
        echo
        '<div class="detail-container">
          <div class="left-part">
          <img src="' . $assoc_id['image_url'] . '"/>
          </div>
          <div class="right-part">
          <h5>' . $assoc_id["titre"] . '</h5>
          <p>' . $assoc_id["description"] . '</p>
          <button>Ajouter au panier</button>
          </div>
        </div>';
    }
}
// Fermeture de la connexion à la base de données
mysqli_close($con);

// AJOUT DU FOOTER
include "../includes/footer.php";
