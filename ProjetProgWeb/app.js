let navbarForm = document.querySelector('.navbar-form')
let searchBar = document.querySelector('#searchbar')
let searchBarButton = document.querySelector('#search-button')
let suggestions = document.querySelector('#suggestions')
let loader = document.querySelector('.loader')
let error = document.querySelector("#error")
let errorMessage = document.querySelector("#error-message")
let errorButton = document.querySelector("#error-button")

let authorName = "";
let lastRequest = null

function requestToApi(author) {
    if (lastRequest === null || (new Date().getTime() - lastRequest) > 1000) {
        lastRequest = new Date().getTime()
        document.querySelector('#results-count').innerHTML = ""
        document.querySelector('#results').innerHTML = ""
        loader.style.display = "block"
        authorName = author.replace(/[^a-zA-Z0-9]/g,'')
        console.log(authorName)
        fetch(`api.php?q=theses&author=${author}`)
            .then(response => response.json())
            .then(data => displayResults(data))
    } else {
        alert('Veuillez attendre une seconde entre chaque recherche.')
    }
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

    if (results.status === 400) {
        loader.style.display = "none"
        error.classList.add("fade-in");
        errorMessage.innerHTML = results.message
        return;
    } else if (results.status === 200) {
        let count = 0

        results.data.forEach(elem => {
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
}

let lastSearch = ""
let lastSuggestion = new Date().getTime()
let suggestionsDisplayed = false

function realTimeDisplay() {
    let search = document.querySelector('input[name=\'author\']').value
    search = search.replace(/[^a-zA-Z0-9 ]/g,'')
    if (search.length > 3 && (search !== lastSearch || (new Date().getTime() - lastSuggestion) > 500)) {
        showSuggestions()
        lastSearch = search
        lastSuggestion = new Date().getTime()
        fetch(`api.php?q=authors&author=${search}`)
            .then(response => response.json())
            .then(results => {
                suggestions.innerHTML = ""
                results.data.forEach(elem => {
                    let name = document.createElement('p')
                    name.innerHTML = elem
                    name.addEventListener('click', () => {
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
        searchBarButton.classList.replace('animation-in', 'animation-out')
        suggestionsDisplayed = true
    }
}

document.addEventListener('click', e => {
    if (e.target.id !== 'suggestions' && e.target !== searchBar && e.target !== searchBarButton) {
        if (suggestionsDisplayed) {
            navbarForm.style.borderRadius = '15px'
            suggestions.style.display = 'none'
            searchBarButton.style.boxShadow = 'rgba(0, 0, 0, 0.15) 4px 2px 5px'
            searchBarButton.classList.replace('animation-out', 'animation-in')
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

        if (e.target === errorButton) {
            error.classList.replace('fade-in', 'fade-out')
        }
    }
})

navbarForm.addEventListener('submit', e => {
    e.preventDefault()
    let data = new FormData(navbarForm)
    searchBar.blur()
    requestToApi(data.get('author'))
})
