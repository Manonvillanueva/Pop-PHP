<?php
// Démarrer la session avant toute autre chose
session_start();

// AJOUT DU HEADER 
include "../includes/header.php";

// Vérifie si le formulaire a été soumis (si des données POST existent)
if (!empty($_POST)) {
    // Tableau pour stocker les erreurs de connexion
    $error_login = [];

    // CONNEXION BDD 
    // Connexion à la base de données avec mysqli_connect
    $con = mysqli_connect("db", "root", "example", "pop_php");
    if (!$con) {
        // Si la connexion échoue, le script s'arrête et affiche l'erreur
        die("Connexion échouée : " . mysqli_connect_error());
    } else {

        // PREPARATION REQ SQL
        // Cherchez l'utilisateur dans la base de données par son email
        $query = "SELECT firstname, mail, password FROM user WHERE mail = ?";
        // Si la requête préparée a réussi
        if ($stmt = mysqli_prepare($con, $query)) {
            // On lie l'email de l'utilisateur entré dans le formulaire à la requête préparée
            mysqli_stmt_bind_param($stmt, "s", $_POST['email_login']);
            // Exécution de la requête SQL préparée
            mysqli_stmt_execute($stmt);
            // On stocke les résultats 
            mysqli_stmt_store_result($stmt);
            // Si aucun résultat n'est retourné (aucun utilisateur trouvé avec l'email), on ajoute une erreur
            if (mysqli_stmt_num_rows($stmt) === 0) {
                $error_login["email_login"] = "Vous n'avez pas de compte avec ce mail";
            } else {
                // Si l'email est trouvé:
                // Lier les résultats à des variables PHP
                // Cela permet d'accéder facilement aux informations de l'utilisateur récupérées
                mysqli_stmt_bind_result($stmt, $firstname_db, $mail_db, $password_db);
                mysqli_stmt_fetch($stmt);
                // Vérification si le mdpasse entré par l'utilisateur correspond au mdpasse stocké dans la BDD
                // 'password_verify' compare le mot de passe haché avec celui saisi dans le formulaire
                if (password_verify($_POST['password_login'], $password_db)) {
                    // Si les informations sont valides, on stocke les informations dans la session
                    // Ces informations pourront être utilisées sur d'autres pages
                    $_SESSION['firstname'] = $firstname_db;
                    $_SESSION['email'] = $mail_db;
                    // Redirection vers la page d'accueil après une connexion réussie
                    header("Location: ../index.php");
                    exit();
                } else {
                    // Si le mdpasse est faux on ajoute une erreur 
                    $error_login["password_login"] = "Votre Mdpasse est faux";
                }
            }
        }
        foreach ($error_login as $error_value) {
            echo '<p> ' . $error_value . ' </p>';
        }
    }
    // Fermeture de la connexion à la base de données
    mysqli_close($con);
}
?>

<main>
    <div>
        <h2>connexion</h2>
        <form method="POST">
            <input type="email" name="email_login" id="" placeholder="Email">
            <input type="password" name="password_login" id="" placeholder="Mot de passe">
            <button type="submit">connexion</button>
        </form>
        <a href="./register.php">Créer un compte</a>
    </div>
</main>;

<!-- AJOUT DU FOOTER -->
<?php include "../includes/footer.php" ?>



<!-- STYLE PART  -->
<style>
    main {
        height: 100%;
    }
</style>