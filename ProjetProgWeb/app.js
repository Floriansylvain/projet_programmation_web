let navbarForm = document.querySelector('.navbar-form')
let searchBar = document.querySelector('#searchbar')
let searchBarButton = document.querySelector('#search-button')
let suggestions = document.querySelector('#suggestions')
let loader = document.querySelector('.loader')

let authorName = "";

function requestToApi(author) {
    loader.style.display = "block"
    authorName = author
    fetch(`api.php?q=theses&author=${author}`)
        .then(response => response.json())
        .then(data => displayResults(data))
}

let elementsToFade = null
function fadeIn() {
    elementsToFade.forEach(elem => {
        let distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
        if (distInView < 0) {
            elem.classList.add("fade-in");
        }
    })
}

// TODO : Faire un système de page plutôt que de charger 10000 résultats en une fois s'il y en a 10000..
function displayResults(results) {
    let count = 0

    results.forEach(elem => {
        let result = document.createElement('div')
        result.classList.add('result-element')
        let i = 0
        elem.forEach(e => {
            let child = document.createElement(i === 0 ? 'h1' : 'p')
            child.innerText = e
            result.appendChild(child)
            i += 1
        })
        count += 1
        document.getElementById('results').appendChild(result)
    })

    let nb = document.createElement("p")
    nb.innerHTML = `Nombre de résultats pour "${authorName}": ${count}.`
    document.getElementById('results-count').appendChild(nb)

    loader.style.display = "none"

    elementsToFade = document.querySelectorAll(".result-element")
    window.addEventListener('scroll', fadeIn);
    fadeIn()
}

let lastSearch = ""
let last = new Date().getTime()
let suggestionsDisplayed = false

function realTimeDisplay() {
    let search = document.getElementsByName("author")[0].value
    if (search.length > 3 && (search !== lastSearch || (new Date().getTime() - last) > 500)) {
        showSuggestions()
        lastSearch = search
        last = new Date().getTime()
        fetch(`api.php?q=authors&author=${search}`)
            .then(response => response.json())
            .then(function(data) {
                suggestions.innerHTML = ""
                data.forEach(elem => {
                    let name = document.createElement('p')
                    name.innerHTML = elem
                    name.addEventListener('click', () => {
                        document.querySelector('#results-count').innerHTML = ""
                        document.querySelector('#results').innerHTML = ""
                        searchBar.value = elem
                        requestToApi(elem)
                    })
                    suggestions.appendChild(name)
                })
            })
    }
}

function showSuggestions() {
    if (!suggestionsDisplayed) {
        navbarForm.style.borderRadius = '15px 15px 0 0'
        suggestions.style.display = 'block'
        searchBarButton.style.boxShadow = 'none'
        searchBarButton.classList.remove('animation-in')
        searchBarButton.classList.add('animation-out')
        suggestionsDisplayed = true
    }
}

document.addEventListener('click', function (e){
    if (e.target.id !== 'suggestions' && e.target !== searchBar && e.target !== searchBarButton) {
        if (suggestionsDisplayed) {
            navbarForm.style.borderRadius = '15px'
            suggestions.style.display = 'none'
            searchBarButton.style.boxShadow = 'rgba(0, 0, 0, 0.15) 4px 2px 5px'
            searchBarButton.classList.remove('animation-out')
            searchBarButton.classList.add('animation-in')
            suggestionsDisplayed = false
        }

        if (e.target.id === 'hamburger' || e.target.id === 'hamburgerSvg' || e.target.id === 'crossSvg') {
            let ham = document.querySelector('#hamburgerSvg')
            let cross = document.querySelector('#crossSvg')
            if (ham.classList.contains('spin-fade')) {
                cross.classList.add('spin-fade')
                ham.classList.remove('spin-fade')
            }
            else {
                ham.classList.add('spin-fade')
                cross.classList.remove('spin-fade')
            }
        }
    }
})
