<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css">
    <title>POP MANIA</title>
</head>

<body>
    <!-- HEADER  -->
    <?php include "./includes/header.php" ?>

    <!-- MAIN : section principale contenant le tri et les produits  -->
    <main>
        <!-- SORT CONTAINER : section pour les filtres -->
        <section class="sort-container">
            <!-- FILTRAGE PAR CAT  -->
            <div class="categorie-sort">
                <p>Catégories </p>
                <ul>
                    <?php
                    // $con est la variable qui stocke la connexion à la base de données créée par la fonction mysqli_connect.
                    $con = mysqli_connect("db", "root", "example", "pop_php");
                    // die() : Si la connexion échoue, la fonction die() est appelée. Elle fait deux choses : 
                    // arrête immédiatement l'exécution du script PHP. Aucune ligne de code après die() ne sera exécutée.
                    // affiche un message d'erreur
                    if (!$con) {
                        // Utilisation de mysqli_connect_error qui décrit pourquoi la connexion a échoué.
                        die("Connexion échouée : " . mysqli_connect_error());
                    } else {
                        // mysqli_query() est une fonction PHP qui permet d'exécuter une requête SQL sur une base de données MySQL
                        // Elle a deux paramètres 
                        // Le premier paramètre ($con) est la connexion à la base de données. 
                        // Le 2nd est la requête SQL (dans ce cas, "SELECT univers FROM articles").
                        $req0 = mysqli_query($con, "SELECT DISTINCT univers FROM articles");
                        if (mysqli_num_rows($req0) == 0) {
                            echo '<li>Aucune catégories trouvées ...</li>';
                        } else {
                            // Boucle pour afficher chaque catégorie
                            while ($assocCat = mysqli_fetch_assoc($req0)) {
                                echo '<li><button>' . $assocCat['univers'] . '</button></li>';
                            }
                        }
                    }

                    ?>
                </ul>
            </div>

            <!-- FILTRAGE PAR PRIX  -->
            <div class="price-sort">
                <p>Prix </p>
                <div>
                    <button><i class="fa-solid fa-arrow-down"></i></button>
                    <button><i class="fa-solid fa-arrow-up"></i></button>
                </div>
            </div>

            <!-- FILTRAGE PAR ORDRE ALPHABETIQUE  -->
            <div class="alpha-sort">
                <p>Ordre Alphabétique </p>
                <div>
                    <button><i class="fa-solid fa-arrow-up-a-z"></i></button>
                    <button><i class="fa-solid fa-arrow-down-a-z"></i></button>
                </div>
            </div>
        </section>


        <!-- PRODUCTS CONTAINER : section pour l'affichage des produits  -->
        <section class="products-container">
            <?php
            // RECUP DONNÉES DE LA BDD
            $req1 = mysqli_query($con, "SELECT * FROM articles");

            // AFFICHAGE SUR MA PAGE 
            if (mysqli_num_rows($req1) == 0) {
                // echo est utilisé pour afficher du texte HTML depuis PHP.
                echo '<div>Aucun produits trouvés ...</div>';
            } else {
                // Boucle pour afficher chaque produit
                while ($assoc = mysqli_fetch_assoc($req1)) {
                    echo '<div class="products"> 
                        <div class="head-products"><a href="../pages/detail.php?id=' . $assoc['id'] . '"><img src="' . $assoc['image_url'] . '" alt="' . $assoc['titre'] . '"/></a></div>
                        <div class="footer-products">
                         <h2>' . $assoc['titre'] . '</h2>
                         <p>' . $assoc['prix'] . '€</p>
                         <button class="add-to-cart" data-id=' . $assoc['id'] . ' >ajouter au panier</button>
                        </div>
                    </div>';
                }
            }
            mysqli_close($con);
            ?>
        </section>
    </main>


    <!-- FOOTER  -->
    <?php include "./includes/footer.php" ?>
    <script>
        console.log("Polices disponibles : ", document.fonts);
    </script>
    <script src="../scripts/addCart.js"></script>
</body>

</html>

<!-- STYLE PART  -->
<style>
    /* Conteneur bloc de tri  */
    .sort-container {
        background: #f8f8f8;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        padding: 20px;
        margin: 20px auto;
        max-width: 1200px;
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        gap: 20px;
    }

    /* Les blocs individuels de tri */
    .sort-container>div {
        border-radius: 10px;
        padding: 10px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* Les titres dans chaque bloc */
    .sort-container p {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    /* Liste des catégories */
    .sort-container ul {
        list-style: none;
    }

    /* Les boutons dans chaque bloc */
    .sort-container button {
        background: #ffba08;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 10px 15px;
        margin-bottom: 3px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    /* Effet au survol des boutons */
    .sort-container button:hover {
        background: #e59400;
        color: white;
        transform: scale(1.05);
    }

    .categorie-sort button {
        width: 140px;
    }

    /* Les icônes dans les blocs de tri (flèches et symboles) */
    .sort-container i {
        font-size: 24px;
        color: #555;
        transition: color 0.3s ease;
    }

    /* Effet au survol des icônes */
    .sort-container i:hover {
        color: white;
    }

    /* Conteneur DES produits */
    .products-container {
        padding: 20px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Chaque produit individuel */
    .products {
        padding: 20px;
        width: 250px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 6px 6px rgba(0, 0, 0, 0.23);
        border-radius: 10px;
    }

    /* Partie supérieure des produits (image) */
    .head-products {
        height: 300px;
        display: flex;
        align-items: center;
    }

    /* Image des produits */
    .head-products img {
        max-width: 100%;
    }

    /* Titre des produits */
    .footer-products h2 {
        height: 50px;
        font-size: 15px;
        text-transform: uppercase;
    }

    /* Bouton "ajouter au panier" */
    .footer-products button {
        margin-top: 5px;
        width: 100%;
        padding: 10px 0;
        font-family: "Open Sans", serif;
        font-weight: bold;
        text-transform: uppercase;
        border: none;
        border-radius: 50px;
        background: #dcdcdc;
    }

    /* Effet au survol du bouton "ajouter au panier" */
    .footer-products button:hover {
        cursor: pointer;
        outline: 2px solid black;
    }

    @media (max-width:620px) {

        /* Container bloc de tri  */
        .sort-container {
            flex-direction: column;
            gap: 10px;
        }

        /* Container liste catégories pop  */
        .categorie-sort ul {
            column-count: 2;
        }

        /* Les icônes dans les blocs de tri (flèches et symboles) */
        .sort-container i {
            font-size: 18px;
        }

    }
</style>