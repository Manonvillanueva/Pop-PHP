<header class="nav-container">
    <!-- TITLE  -->
    <h1 class="site-title">POP MANIA</h1>

    <!-- SEARCH INPUT  -->
    <form action="">
        <input type="text" placeholder="Rechercher ..." aria-label="search bar">
    </form>

    <!-- LINK NAV -->
    <nav>
        <!-- Utilisation d'aria label lorsque tu veux fournir une description d'un élément qui n'a pas de texte visible comme un bouton ou une icône ... Alt s'utilise uniquement sur les img -->
        <ul class="nav-link">
            <!-- Home  -->
            <li><a href="index.php" aria-label="home page">
                    <i class="fa-solid fa-house"></i>
                </a></li>
            <!-- Profil  -->
            <li><a href="../pages/connexion.php" aria-label="profil">
                    <i class="fa-solid fa-user"></i>
                </a></li>
            <!-- Basket  -->
            <li><a href="../pages/basket.php" aria-label="basket">
                    <i class="fa-solid fa-basket-shopping"></i>
                </a></li>
        </ul>
    </nav>
</header>

<style>
    .nav-container {
        display: flex;
        justify-content: space-around;
    }

    h1 {
        font-family: 'Bangers', cursive;
    }

    .nav-link {
        display: flex;
        list-style: none;
    }
</style>