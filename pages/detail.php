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
        echo '<main>
        <div class="detail-container">
        <p>Produit non trouvé ...</p>
        </div>
        </main>';
    } else {
        // Si un produit est trouvé, récupérer les données du produit
        $assoc_id = mysqli_fetch_assoc($req_id);
        // Affichage des détails du produit dans une structure HTML
        echo
        '<main>
        <div class="detail-container">
          <div class="left-part">
          <img src="' . $assoc_id['image_url'] . '" alt="' . $assoc_id['titre'] . '">
          </div>
          <div class="right-part">
          <h3>' . $assoc_id["titre"] . '</h3>
          <p class="description">' . $assoc_id['description'] . '</p>
          <p class="price">' . $assoc_id['prix'] . '€</p>
          <button><a href="../functions/addBasket.php?product_id=' . $id . '">Ajouter au panier</a></button>
          </div>
        </div>
        </main>';
    }
}
// Fermeture de la connexion à la base de données
mysqli_close($con);

// AJOUT DU FOOTER
include "../includes/footer.php";
?>

<style>
    /* Afin d'abaisser le footer en bas de la page  */
    main {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
    }

    /* Conteneur principal du détail de la pop */
    .detail-container {
        display: flex;
        gap: 40px;
        margin: 40px 20px;
        padding: 20px;
        background: #f8f8f8;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Container gauche pour l'image */
    .left-part {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    /* Image de la pop */
    .left-part img {
        max-width: 100%;
        padding: 10px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Container droit pour les infos */
    .right-part {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Nom de la pop  */
    .right-part h3 {
        font-size: 30px;
        font-family: 'Bangers', serif;
        letter-spacing: 1px;
        color: #333;
    }

    /* Description de la pop  */
    .description {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
    }

    /* Prix de la pop  */
    .price {
        font-size: 20px;
        font-weight: bold;
        color: #ff5722;
    }

    /* Bouton ajouter au panier  */
    .right-part button {
        padding: 15px 20px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background: #ffba08;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Effet de survol du bouton ajouter au panier  */
    .right-part button:hover {
        background: #e59400;
    }

    @media (max-width:620px) {

        /* Conteneur principal du détail de la pop */
        .detail-container {
            flex-direction: column;
        }

    }
</style>