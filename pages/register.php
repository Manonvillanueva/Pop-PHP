<?php
if (!empty($_POST)) {

    $con = mysqli_connect("db", "root", "example", "pop_php");
    $errors = [];
    if (empty($_POST["firstname_register"]) || !preg_match('/^[a-zA-Z\s\-]+$/', $_POST["firstname_register"])) {
        $errors["firstname_register"] = "Votre prénom est vide ou contient des caractères non valides.";
    }

    if (empty($_POST["lastname_register"]) || !preg_match('/^[a-zA-Z\s\-]+$/', $_POST["lastname_register"])) {
        $errors["lastname_register"] = "Votre nom est vide ou contient des caractères non valides.";
    }

    if (empty($_POST["email_register"]) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["email_register"])) {
        $errors["email_register"] = "Votre mail est vide ou contient des caractères non valides.";
    } else {
        $req_mail = mysqli_query($con, "SELECT mail FROM user WHERE mail='$_POST[email_register]'");
        if (mysqli_num_rows($req_mail) > 0) {
            $errors["email_register"] = "Votre mail est déjà utilisé.";
        }
    }

    if (empty($_POST["password_register"]) || !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $_POST["password_register"])) {
        $errors["password_register"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole spécial.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($_POST['password_register'], PASSWORD_DEFAULT);
        $query = "INSERT INTO user (firstname, lastname, mail, password) VALUES ('" . $_POST['firstname_register'] . "', '" . $_POST['lastname_register'] . "', '" . $_POST['email_register'] . "', '$hashedPassword')";
        if (mysqli_query($con, $query)) {
            header("Location: ../index.php");
            exit();
        }
    }
    var_dump($errors);
}

?>
<div class="form-container">
    <p>Créer un compte</p>
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