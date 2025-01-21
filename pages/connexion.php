<?php
// Démarrer la session avant toute autre chose
session_start();
// HEADER 
include "../includes/header.php";

// MAIN
// Vérifie si l'utilisateur est connecté en vérifiant si la variable de session est définie
if (isset($_SESSION['email'])) {
  echo '<p>Bonjour ' . $_SESSION['firstname'] . '</p>';
  echo '<ul>
          <li>Mes commandes</li>
          <li>Mes informations</li>
        </ul>';
  echo '<button><a href="../includes/logout.php">Déconnexion</a></button>';
} else {
  // Formulaire de connexion 
  echo '<main>
       <div>
         <h2>connexion</h2>
          <form>
            <input type="email" name="" id="" placeholder="Email">
            <input type="password" name="" id="" placeholder="Mot de passe">
            <button type="submit">connexion</button>
          </form>
          <a href="./register.php">Créer un compte</a>
        </div>
       </main>';
}

// FOOTER 
include "../includes/footer.php";
