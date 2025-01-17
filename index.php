<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <title>POP MANIA</title>
</head>

<body>
    <!-- HEADER  -->
    <?php include "./includes/header.php" ?>

    <!-- MAIN : section principale contenant le tri et les produits  -->
    <main>
        <!-- SORT CONTAINER : section pour les filtres -->
        <section class="sort-container">
            <h2>Filtrer par :</h2>
            <!-- FILTRAGE PAR CAT  -->
            <div class="categorie-sort">
                <h3>Catégories </h3>
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
                <h3>Prix </h3>
                <button><i class="fa-solid fa-arrow-down"></i></button>
                <button><i class="fa-solid fa-arrow-up"></i></button>
            </div>

            <!-- FILTRAGE PAR ORDRE ALPHABETIQUE  -->
            <div class="alpha-sort">
                <h3>Ordre Alphabétique </h3>
                <button><i class="fa-solid fa-arrow-up-a-z"></i></button>
                <button><i class="fa-solid fa-arrow-down-a-z"></i></button>
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

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    img {
        height: 100px;
        width: 100px;
    }
</style>