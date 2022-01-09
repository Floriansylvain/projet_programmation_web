<header>

    <nav class="navbar">

        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="hamburger">
            <path id="hamburgerSvg" d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
            <path id="crossSvg" class="spin-fade" d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/>
        </svg>

        <h1 id="title"><a href="index.php">theses.fr</a></h1>

        <div class="research-section">
            <form class="navbar-form" method="GET" action="index.php">
                <input type="text" name="search" placeholder="recherche" onkeyup="realTimeDisplay()" id="searchbar" maxlength="100">
                <input style="display:none" type="text" name="option">
                <input style="display:none" type="text" name="offset">
                <button id="form-button">
                    <img src="assets/search.svg" alt="search" id="search-button" class="animation-in">
                </button>
            </form>
            <div id="suggestions"></div>
        </div>

    </nav>

    <div id="hamburger-menu">

        <div>
            <h3>Filtres : </h3>
            <div class="filters">
                <p id="f-auto">Auto</p>
                <p id="f-title">Titre</p>
                <p id="f-author">Auteur</p>
                <p id="f-director">Directeur</p>
                <p id="f-establishment">Etablissement</p>
            </div>
        </div>

        <div>
            <h3>Options : </h3>

            <div>
                <div class="chart-button">
                    <svg id="chart-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.012 5.007v-1.668l2.802-2.771c.409.136.809.293 1.197.471l-3.999 3.968zm7.089-1.93l-7.089 7.058v.853h.877l7.044-7.076c-.263-.292-.541-.57-.832-.835zm-7.089-1.468l1.437-1.406c-.46-.094-.96-.163-1.437-.203v1.609zm10.789 7.962l-1.386 1.417h1.585c-.04-.47-.106-.964-.199-1.417zm-.363-1.366c-.135-.41-.292-.81-.469-1.199l-3.951 3.982h1.668l2.752-2.783zm-1.063-2.337c-.205-.346-.426-.682-.664-1.004l-6.093 6.124h1.668l5.089-5.12zm-3.225-3.57c-.322-.238-.657-.459-1.003-.665l-5.135 5.104v1.668l6.138-6.107zm-8.15 10.702v-13c-6.161.519-11 5.683-11 11.978 0 6.639 5.382 12.022 12.021 12.022 6.296 0 11.46-4.839 11.979-11h-13z"/>
                    </svg>
                    <div class="toggle-switch">
                        <div class="slider toggle"></div>
                    </div>
                </div>

                <div class="chart-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M18 0c-3.148 0-6 2.553-6 5.702 0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298 0-3.149-2.852-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm-12-3c-2.099 0-4 1.702-4 3.801 0 3.121 3.188 3.451 4 8.199.812-4.748 4-5.078 4-8.199 0-2.099-1.901-3.801-4-3.801zm0 5.333c-.737 0-1.333-.597-1.333-1.333s.596-1.333 1.333-1.333 1.333.596 1.333 1.333-.596 1.333-1.333 1.333zm6 5.775l-3.215-1.078c.365-.634.777-1.128 1.246-1.687l1.969.657 1.92-.64c.388.521.754 1.093 1.081 1.75l-3.001.998zm12 7.892l-6.707-2.427-5.293 2.427-5.581-2.427-6.419 2.427 3.62-8.144c.299.76.554 1.776.596 3.583l-.443.996 2.699-1.021 4.809 2.091.751-3.725.718 3.675 4.454-2.042 3.099 1.121-.461-1.055c.026-.392.068-.78.131-1.144.144-.84.345-1.564.585-2.212l3.442 7.877z"/>
                    </svg>
                    <div class="toggle-switch">
                        <div class="slider toggle"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</header>
