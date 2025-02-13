// UTILISATION AJAX =>
// JS envoie une requête en arrière-plan à addBasket.php via fetch().
// PHP traite la requête et renvoie une réponse en JSON.
// JS met à jour sans recharger la page, alors qu'avec PHP il y aurait automatiquement eu une redirection.

// Sélectionne tous les boutons ayant la classe "add-to-cart"
document.querySelectorAll(".add-to-cart").forEach((button) => {
  // Ajoute un écouteur d'événement "click" sur chaque bouton
  button.addEventListener("click", (e) => {
    // Annuler l'évènement par défault pour éviter l'actualisation de la page
    e.preventDefault();
    // Récupère l'ID du produit qui est stocké dans l'attribut "data-id" du bouton
    let productId = button.getAttribute("data-id");
    // Change le texte du bouton en "Ajouté"
    button.textContent = "Ajouté";

    //fetch() sert à faire des requêtes HTTP, donc :
    // Récupérer des données d’une API (GET)
    // Envoyer des données à un serveur (POST, PUT, DELETE)

    // Envoie une requête AJAX au fichier PHP qui gère l'ajout au panier
    fetch("../functions/addBasket.php", {
      // Utilise la méthode POST pour envoyer des données au serveur
      method: "POST",
      // Ça signifie qu'on envoie les données sous forme de formulaire classique
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      // Affiche la réponse du serveur dans la console
      body: "articles_id=" + productId,
    })
      .then((response) => response.json())
      .then((data) => {
        // data.success : C'est une propriété de l'objet data. C'est une valeur booléenne (true ou false)
        if (!data.success) {
          alert("Erreur : " + data.message);
          button.textContent = "Ajouter au panier";
        }
      })
      // Le .catch() est là pour attraper les erreurs qui pourraient survenir lors de l'exécution du fetch().
      .catch((error) => console.error("Erreur AJAX :", error));

    // Restaure le texte du bouton après 1 seconde
    setTimeout(() => {
      // Restaure le texte
      button.textContent = "Ajouter au panier";
    }, 1000);
  });
});
