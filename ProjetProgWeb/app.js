let navbarForm = document.querySelector('.navbar-form')
let searchBar = document.querySelector('#searchbar')
let searchBarButton = document.querySelector('#search-button')
let suggestions = document.querySelector('#suggestions')
let loader = document.querySelector('.loader')
let error = document.querySelector('#error')
let errorMessage = document.querySelector('#error-message')
let errorButton = document.querySelector('#error-button')
let hamMenu = document.querySelector('#hamburger-menu')
let header = document.querySelector('header')
let title = document.querySelector('#title')

function sanitize(chain) {
    return chain.replace(/[^a-zA-Z0-9 ]/g,'')
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

function hideSuggestions() {
    if (suggestionsDisplayed) {
        navbarForm.style.borderRadius = '15px'
        suggestions.style.display = 'none'
        searchBarButton.style.boxShadow = 'rgba(0, 0, 0, 0.15) 4px 2px 5px'
        searchBarButton.classList.replace('animation-out', 'animation-in')
        suggestionsDisplayed = false
    }
}

let authorName = "";
let lastRequest = null

function requestToApi(author) {
    hideSuggestions()
    if (lastRequest === null || (new Date().getTime() - lastRequest) > 1000) {
        lastRequest = new Date().getTime()
        document.querySelector('#results-count').innerHTML = ""
        document.querySelector('#results').innerHTML = ""
        loader.style.display = "block"
        authorName = sanitize(author)
        fetch(`api.php?q=theses&author=${author}`)
            .then(response => response.json())
            .then(data => displayResults(data))
    } else {
        alert('Veuillez attendre une seconde entre chaque recherche.')
    }
}

window.addEventListener('scroll', fadeIn);
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
        fadeIn()
    }
}

let lastSearch = ""
let lastSuggestion = new Date().getTime()
let suggestionsDisplayed = false

function realTimeDisplay() {
    let search = document.querySelector('input[name=\'author\']').value
    search = sanitize(search)
    if (search.length > 3 && (search !== lastSearch && (new Date().getTime() - lastSuggestion) > 500)) {
        lastSearch = search
        lastSuggestion = new Date().getTime()
        fetch(`api.php?q=authors&author=${search}`)
            .then(response => response.json())
            .then(results => {
                suggestions.innerHTML = ""
                if (!results.data.length) {
                    hideSuggestions()
                } else {
                    showSuggestions()
                }
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

document.addEventListener('click', e => {
    if (e.target.id !== 'suggestions' && e.target !== searchBar && e.target !== searchBarButton) {

        hideSuggestions()

        title.style.display = 'block'

        if (e.target.id === 'hamburger' || e.target.id === 'hamburgerSvg' || e.target.id === 'crossSvg') {
            let ham = document.querySelector('#hamburgerSvg')
            let cross = document.querySelector('#crossSvg')
            if (ham.classList.contains('spin-fade')) {
                cross.classList.add('spin-fade')
                ham.classList.remove('spin-fade')
                header.classList.replace('slide-in-header', 'slide-out-header')
                hamMenu.classList.replace('slide-in', 'slide-out')
            }
            else {
                ham.classList.add('spin-fade')
                cross.classList.remove('spin-fade')
                header.classList.remove('slide-out-header')
                header.classList.add('slide-in-header')
                hamMenu.classList.remove('slide-out')
                hamMenu.classList.add('slide-in')
            }
        }

        if (e.target === errorButton) {
            error.classList.replace('fade-in', 'fade-out')
        }

        let toggleSwitch = null
        if (e.target.classList.contains('slider')) {
            toggleSwitch = e.target
        } else if (e.target.classList.contains('toggle-switch')) {
            toggleSwitch = e.target.firstElementChild
        }
        if (toggleSwitch !== null) {
            if (toggleSwitch.classList.contains('untoggle')) {
                toggleSwitch.classList.replace('untoggle', 'toggle')
            } else {
                toggleSwitch.classList.replace('toggle', 'untoggle')
            }
        }

    }
})

searchBar.addEventListener('focus', () => {
    title.style.display = 'none'
})

navbarForm.addEventListener('submit', e => {
    e.preventDefault()
    let data = new FormData(navbarForm)
    searchBar.blur()
    requestToApi(data.get('author'))
})
