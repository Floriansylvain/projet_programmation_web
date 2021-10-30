<header>
    <nav class="navbar">
        <h1>theses.fr</h1>

        <div class="research-section">
            <form action="index.php" method="GET" class="navbar-form">
                <input type="text" name="author" placeholder="nom auteur" onkeyup="realTimeDisplay()" id="searchbar">
                <button>
                    <img src="assets/search.svg" alt="search" id="search-button">
                </button>
            </form>
            <div id="suggestions"></div>
        </div>

    </nav>
</header>
