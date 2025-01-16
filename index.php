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
    <header>
        <?php include "./includes/header.php" ?>
    </header>


    <!-- MAIN  -->
    <main>
        <div class="sort-nav">
        </div>


        <!--    AFFICHAGE DES PRODUITS  -->
        <div class="products-container">
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
                // RECUP DONNÉES DE LA BDD
                // mysqli_query() est une fonction PHP qui permet d'exécuter une requête SQL sur une base de données MySQL
                // Elle a deux paramètres 
                // Le premier paramètre ($con) est la connexion à la base de données. 
                // Le 2nd est la requête SQL (dans ce cas, "SELECT * FROM articles").
                $req1 = mysqli_query($con, "SELECT * FROM articles");

                // AFFICHAGE SUR MA PAGE 
                if (mysqli_num_rows($req1) == 0) {
                    // echo est utilisé pour afficher du texte HTML depuis PHP.
                    echo '<div>Aucun produits trouvés ...</div>';
                } else {
                    while ($assoc = mysqli_fetch_assoc($req1)) {
                        echo '<div class="products"> 
                        <a href="../pages/detail.php?id=' . $assoc['id'] . '"><img src="' . $assoc['image_url'] . '" alt="' . $assoc['titre'] . '"/></a>
                        <h2>' . $assoc['titre'] . '</h2>
                        <p>' . $assoc['prix'] . '€</p>
                        <button>ajouter au panier</button>
                        </div>';
                    }
                }
            }
            ?>
        </div>
    </main>


    <!-- FOOTER  -->
    <footer>
        <?php include "./includes/footer.php" ?>
    </footer>
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