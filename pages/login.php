<?php
// Démarrer la session pour stocker les infos utilisateurs
session_start();

// Vérifie si le formulaire a été soumis (si des données POST existent)
if (!empty($_POST)) {
    // Tableau pour stocker les erreurs
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
                } else {
                    // Si le mdpasse est faux on ajoute une erreur 
                    $error_login["password_login"] = "Votre mot de passe est incorrect";
                }
            }
        }
    }
    // Fermeture de la connexion à la base de données
    mysqli_close($con);
}
// AJOUT DU HEADER
// Inclusion du header après la redirection pour éviter les erreurs
include "../includes/header.php";
?>

<main>

    <!-- Si l'utilisateur est connu dans la SESSION -->
    <?php if (isset($_SESSION['email'])): ?>
        <div class="connexion-container">
            <p>Bonjour <?php echo $_SESSION['firstname']; ?></p>
            <ul class="ul-connexion">
                <li>Mes commandes</li>
                <li>Mes informations</li>
            </ul><button><a href="../includes/logout.php">Déconnexion</a></button>
        </div>

    <?php else: ?>

        <!-- Si l'utilisateur inconnu dans la SESSION -->
        <div class="login-container">
            <h2>connexion</h2>
            <!-- Affichage des erreurs s'il y en a -->
            <?php if (!empty($error_login)): ?>
                <?php foreach ($error_login as $error_value): ?>
                    <p class="error"><?php echo $error_value ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Formulaire de connexion -->
            <form class="login-form" method="POST">
                <input type="email" name="email_login" placeholder="Email">
                <input type="password" name="password_login" placeholder="Mot de passe">
                <button type="submit">Me connecter</button>
            </form>
            <!-- Lien pour créer un comtpe -->
            <a class="register-link" href="./register.php">Créer un compte</a>
        </div>
    <?php endif; ?>
</main>

<!-- AJOUT DU FOOTER -->
<?php include "../includes/footer.php" ?>



<!-- STYLE PART  -->
<style>
    /* Container principal de la page  */
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f8f8;
    }

    /* UTILISATEUR INCONNU DANS LA SESSION  */
    /* Container du formulaire de connexion  */
    .login-container {
        background-color: white;
        padding: 30px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width: 400px;
        text-align: center;
    }

    /* Titre du formulaire de connexion  */
    .login-container h2 {
        font-size: 24px;
        text-transform: uppercase;
        color: #333;
        margin-bottom: 20px;
    }

    /* Messages d'erreur  */
    .error {
        color: red;
        margin: 10px 0;
        font-size: 14px;
    }

    /* Champs du formulaire de connexion */
    .login-form input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    /* Bouton de connexion  */
    .login-form button {
        width: 100%;
        padding: 10px;
        background-color: #ffba08;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Effet de survol sur le bouton de connexion  */
    .login-form button:hover {
        background-color: #e59400;
    }

    /* Lien de création de compte  */
    .register-link {
        display: inline-block;
        margin-top: 15px;
        color: #333;
    }

    /* Effet de survol sur le lien de création de compte  */
    .register-link:hover {
        text-decoration: underline;
    }

    /* SI UTILISATEUR CONNU DE LA SESSION  */

    /* Container utilisateur connecté  */
    .connexion-container {
        border-radius: 10px;
        padding: 80px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    /* Texte de bienvenue */
    .connexion-container p {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    /* Liste d'options utilisateur */
    .ul-connexion li {
        background: rgb(179, 179, 179);
        color: white;
        padding: 10px;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* Bouton de déconnexion */
    .connexion-container button {
        background: #ffba08;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        margin-top: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    /* Effet de survol sur le btn de déconnexion  */
    .connexion-container button:hover {
        background: #e59400;
    }
</style>