<?php
// Démarrer la session avant toute autre chose
session_start();
// HEADER 
include "../includes/header.php";

// MAIN

// AFFICHAGE SI USER CONNECTE 
// Vérifie si l'utilisateur est connecté en vérifiant si la variable de session est définie
if (isset($_SESSION['email'])) {
  echo '<p>Bonjour ' . $_SESSION['firstname'] . '</p>';
  echo '<ul>
          <li>Mes commandes</li>
          <li>Mes informations</li>
        </ul>';
  echo '<button><a href="../includes/logout.php">Déconnexion</a></button>';
} else {

  // AFFICHARGE SI USER NON CONNECTE
  // Formulaire de connexion 
  echo '<main>
       <div>
       <button><a href="../pages/login.php">Se connecter</a></button>
        </div>
       </main>';
}

// FOOTER 
include "../includes/footer.php";
