<header>
    <nav class="navbar">
        <h1>theses.fr</h1>

        <!-- svg from iconmonstr -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="hamburger">
            <path id="hamburgerSvg" d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
            <path id="crossSvg" class="spin-fade" d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/>
        </svg>

        <div class="research-section">
            <form class="navbar-form">
                <input type="text" name="author" placeholder="nom auteur" onkeyup="realTimeDisplay()" id="searchbar">
                <button id="form-button">
                    <img src="assets/search.svg" alt="search" id="search-button" class="animation-in">
                </button>
            </form>
            <div id="suggestions"></div>
        </div>

    </nav>
</header>
