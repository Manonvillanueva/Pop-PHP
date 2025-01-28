 <footer class="footer-container">
     <!-- LEFT PART  -->
     <div class="slogan">
         <p>
             "Pop Mania : Les figurines qui font vibrer votre passion !"
         </p>
     </div>

     <!-- RIGHT PART  -->
     <div class="link-footer">
         <!-- La valeur "_blank" de l’attribut target indique au navigateur qu’il doit ouvrir le lien dans une nouvelle fenêtre ou un nouvel onglet. -->
         <a href="https://www.instagram.com/funko_europe/" target="_blank">
             <i class="fa-brands fa-instagram"></i>
         </a>
     </div>
 </footer>

 <!-- STYLE PART  -->
 <style>
     /* Container du footer  */
     footer {
         background: black;
         color: white;
         bottom: 0;
         display: flex;
         justify-content: space-between;
         padding: 15px 40px;
         box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.3);
     }

     /* Left part footer (slogan) */
     .slogan {
         font-family: 'Bangers', cursive;
         letter-spacing: 2px;
         font-size: 30px;
     }

     /* Right part footer  */
     .link-footer {
         display: flex;
         align-items: center;
         font-size: 25px;
     }

     /* Logo (lien) insta footer  */
     .link-footer i {
         border: 1px solid white;
         border-radius: 50px;
         padding: 5px;
         transition: transform 0.3s ease;
     }

     /* Effet de survol sur l'icône insta (lien) */
     .link-footer i:hover {
         transform: scale(1.1);
         color: pink;
         border: 1px solid pink;
     }

     @media (max-width:600px) {

         /* Container du footer  */
         footer {
             padding: 15px 20px;
         }

     }

     @media (max-width:450px) {

         /* Left part footer (slogan) */
         .slogan {
             font-size: 18px;
         }
     }
 </style>