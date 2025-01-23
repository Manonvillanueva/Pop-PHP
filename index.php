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

            <div class="image-sort">
                <img src="./assets/batman-sort.png" alt="">
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
                        <a href="../pages/detail.php?id=' . $assoc['id'] . '"><img src="' . $assoc['image_url'] . '" alt="' . $assoc['titre'] . '"/></a>
                        <h4>' . $assoc['titre'] . '</h4>
                        <p>' . $assoc['prix'] . '€</p>
                        <button>ajouter au panier</button>
                        </div>';
                }
            }
            mysqli_close($con);
            ?>
        </section>
    </main>


    <!-- FOOTER  -->
    <?php include "./includes/footer.php" ?>
</body>

</html>

<!-- STYLE PART  -->
<style>
    .sort-container {
        /* background-image: radial-gradient(circle at -16.45% 25.82%, #a3a7ff 0, #7a8ffc 25%, #3c78f2 50%, #0063e8 75%, #0051de 100%); */
        background-image: radial-gradient(circle at 114.09% 20.12%, #f1ba00 66.67%, #eaa400 83.33%, #e58e00 100%);
        display: flex;
        justify-content: space-between;
        padding: 20px 40px;
        text-align: center;
    }

    .sort-container button {
        background: none;
        border: none;
    }

    .sort-container button:hover {
        cursor: pointer;
    }

    .sort-container p {
        font-size: 15px;
        text-transform: uppercase;
        text-decoration: underline;
        font-weight: bold;
    }

    .sort-container i {
        font-size: 30px;
    }

    .categorie-sort ul {
        list-style: none;
    }

    .alpha-sort {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .alpha-sort div {
        display: flex;
        text-align: center;
    }


    .image-sort img {
        height: 200px;
    }

    .products-container img {
        height: 100px;
        width: 100px;
    }
</style>