<header>
    <nav class="navbar">
        <h1>theses.fr</h1>

        <!-- svg from iconmonstr -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="hamburger">
            <path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
        </svg>

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
