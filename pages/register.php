<?php
// Démarrer la session avant toute autre chose
session_start();

// Vérifie si le formulaire a été soumis (si des données POST existent)
if (!empty($_POST)) {

    // CONNEXION BDD
    $con = mysqli_connect("db", "root", "example", "pop_php");
    if (!$con) {
        // Affiche une erreur si la connexion échoue
        die("Connexion échouée : " . mysqli_connect_error());
    }

    // Création d'un tableau pour stocker les erreurs 
    $errors = [];

    // VALIDATION FIRSTNAME FIELD 
    if (empty($_POST["firstname_register"]) || !preg_match('/^[a-zA-Z\s\-]+$/', $_POST["firstname_register"])) {
        // Si le prénom est vide ou contient des caractères invalides
        $errors["firstname_register"] = "Votre prénom est vide ou contient des caractères non valides.";
    }

    // VALIDATION LASTNAME FIELD
    if (empty($_POST["lastname_register"]) || !preg_match('/^[a-zA-Z\s\-]+$/', $_POST["lastname_register"])) {
        // Si le nom est vide ou contient des caractères invalides
        $errors["lastname_register"] = "Votre nom est vide ou contient des caractères non valides.";
    }

    // VALIDATION MAIL FIELD 
    if (empty($_POST["email_register"]) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["email_register"])) {
        // Si l'email est vide ou invalide
        $errors["email_register"] = "Votre mail est vide ou contient des caractères non valides.";
    } else {
        // Préparation d'une requête pour vérifier si le mail est déjà existant dans la BDD
        $query_mail = "SELECT mail FROM user WHERE mail = ?";
        if ($stmt = mysqli_prepare($con, $query_mail)) {
            // Lier l'email à la requête préparée
            mysqli_stmt_bind_param($stmt, "s", $_POST['email_register']);
            // Exécuter la requête préparée
            mysqli_stmt_execute($stmt);
            // Obtenir les résultats
            mysqli_stmt_store_result($stmt);

            // Vérifier si l'email existe déjà dans la BDD
            if (mysqli_stmt_num_rows($stmt) > 0) {
                // Si l'email existe déjà, ajouter une erreur
                $errors["email_register"] = "Votre mail est déjà utilisé.";
            }
        }
        // Fermer la requête
        mysqli_stmt_close($stmt);
    }

    // VALIDATION PASSWORD FIELD 
    if (empty($_POST["password_register"]) || !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $_POST["password_register"])) {
        // Si le mot de passe est vide ou ne correspond pas aux critères de sécurité
        $errors["password_register"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole spécial.";
    }

    // INSERTION DANS LA BDD 
    // Si aucune erreur trouvée
    if (empty($errors)) {

        // Hashage du mot de passe pour le sécuriser avant de l'enregistrer dans la BDD
        $hashedPassword = password_hash($_POST['password_register'], PASSWORD_DEFAULT);

        // PREPARATION REQUETE SQL pour insérer un nouvel utilisateur

        // Ces symboles(?) sont des paramètres préparés. Ils indiquent que les valeurs des colonnes vont être insérées à un moment ultérieur, lorsque les valeurs réelles seront liées à la requête. C'est une protection contre les injections SQL, car les valeurs sont traitées comme des données, et non comme du code SQL.
        $query = "INSERT INTO user (firstname, lastname, mail, password) VALUES (?, ?, ?, ?)";

        // mysqli_prepare() : Cette fonction prépare la requête SQL sur le serveur MySQL en utilisant la connexion $con. La requête est envoyée au serveur pour être compilée, mais elle ne sera pas encore exécutée.
        if ($stmt = mysqli_prepare($con, $query)) {
            $firstname = $_POST['firstname_register'];
            $lastname = $_POST['lastname_register'];
            $email = $_POST['email_register'];

            // mysqli_stmt_bind_param() : Cette fonction lie les variables PHP aux paramètres de la requête préparée. Les paramètres sont représentés par ? dans la requête SQL.
            // "ssss" indique que les 4 paramètres sont des chaînes de caractères (s pour "string").
            mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashedPassword);

            // mysqli_stmt_execute() : Cette fonction exécute la requête préparée avec les paramètres liés. Si l'exécution de la requête réussit, les données sont insérées dans la table user de la BDD.
            if (!mysqli_stmt_execute($stmt)) {
                echo "Erreur : " . mysqli_stmt_error($stmt);
            } else {
                // L'inscription a réussi, alors démarrer la session et stocker les informations de l'utilisateur
                $_SESSION['firstname'] = $firstname;
                $_SESSION['email'] = $email;
                // Redirection après une inscription réussie
                // La fonction exit() est là pour s'assurer que le script s'arrête immédiatement après la redirection (ce qui empêche le code restant de s'exécuter).
                header("Location: ./login.php");
                exit();
            }
        }
    }
    // FERMER LA CO A LA BDD 
    mysqli_close($con);
}
include "../includes/header.php";
?>
<main>
    <div class="form-container">
        <h2>Créer un compte</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach ($errors as $error_value): ?>
                    <p><?php echo $error_value ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <!-- FIRSTNAME FIELD  -->
            <input type="text" name="firstname_register" value="<?php echo $_POST['firstname_register'] ?>" placeholder="Prénom">
            <!-- LASTNAME FIELD  -->
            <input type="text" name="lastname_register" value="<?php echo $_POST['lastname_register'] ?>" placeholder=" Nom de famille">
            <!-- MAIL FIELD  -->
            <input type="email" name="email_register" value="<?php echo $_POST['email_register'] ?>" placeholder=" Email">
            <!-- PASSWORD FIELD  -->
            <input type="password" name="password_register" placeholder="Mot de passe">
            <!-- VALID FORM  -->
            <button type="submit">Créer</button>
        </form>
    </div>
</main>


<!-- FOOTER  -->
<?php include "../includes/footer.php"; ?>

<style>
    main {
        display: flex;
        flex: 1;
        justify-content: center;
        align-items: center;
        background-color: #f8f8f8;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width: 400px;
        text-align: center;
    }

    .form-container h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .error-container {
        background-color: #fff2f2;
        border: 1px solid #ffdddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
    }

    .error-container p {
        color: #dc3545;
        font-size: 14px;
        text-align: left;
    }

    .form-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-container button {
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

    .form-container button:hover {
        background-color: #e59400;
    }
</style>