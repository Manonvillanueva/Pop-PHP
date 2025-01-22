<head>
    <link rel="stylesheet" href="../style.css">
</head>

<header class="nav-container">
    <!-- TITLE  -->
    <h1 class="site-title"><a href="../index.php">POP MANIA</a></h1>

    <!-- SEARCH INPUT  -->
    <form class="search-bar-container" action="">
        <input type="text" class="search-bar" placeholder="Rechercher ..." aria-label="search bar">
    </form>

    <!-- LINK NAV -->
    <nav class="nav-link">
        <!-- Utilisation d'aria label lorsque tu veux fournir une description d'un élément qui n'a pas de texte visible comme un bouton ou une icône ... Alt s'utilise uniquement sur les img -->
        <ul>
            <!-- Home  -->
            <li><a href="../index.php" aria-label="home page">
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

<!-- STYLE PART  -->
<style>
    header {
        padding: 30px 40px;
        background: black;
        color: white;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
    }

    h1 {
        font-family: 'Bangers', cursive;
        font-size: 50px;
        letter-spacing: 3px;
        transition: transform 0.3s ease;
    }

    h1:hover {
        transform: scale(1.1);
        color: yellow;
    }

    .search-bar-container {
        display: flex;
        align-items: center;
    }

    .search-bar {
        padding: 5px 10px;
        font-size: 15px;
        outline: none;
    }

    .nav-link {
        display: flex;
        align-items: center;
    }

    .nav-link ul {
        list-style: none;
        display: flex;
        gap: 8px;
    }

    .nav-link i {
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .nav-link i:hover {
        transform: scale(1.1);
        color: rgb(61, 208, 241);
    }
</style>