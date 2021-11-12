const SMALL = 576
const MEDIUM = 768
const LARGE = 992
const EXTRA_LARGE = 1200

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
let ham = document.querySelector('#hamburgerSvg')
let cross = document.querySelector('#crossSvg')
let pagesNumbers = document.querySelector('.page-nav div')
let resultsDiv = document.querySelector('#results')
let resultsCount = document.querySelector('#results-count')

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

function emptyResults(withCount = false) {
    if (withCount)
        resultsCount.innerHTML = ""
    resultsDiv.innerHTML = ""
}

let authorName = "";
let lastRequest = null

function apiRequestThese(author) {
    hideSuggestions()
    if (lastRequest === null || (new Date().getTime() - lastRequest) > 1000) {
        lastRequest = new Date().getTime()
        emptyResults(true)
        pagesNumbers.innerHTML = ""
        loader.style.display = "block"
        authorName = sanitize(author)
        fetch(`api.php?q=theses&author=${author}`)
            .then(response => response.json())
            .then(data => displayResults(data))
    } else {
        alert('Veuillez attendre une seconde entre chaque recherche.')
    }
}

function fadeIn() {
    let elementsToFade = document.querySelectorAll(".result-element")
    if (elementsToFade !== null) {
        elementsToFade.forEach(elem => {
            let distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
            if (distInView < 0) {
                elem.classList.add("fade-in");
            }
        })
    }
}

window.addEventListener('scroll', fadeIn);

let resultsArray = []
let count = 0

function displayResults(results) {

    if (results.status === 400) {
        loader.style.display = "none"
        error.classList.add("fade-in");
        errorMessage.innerHTML = results.message
        return;
    } else if (results.status === 200) {
        count = 0
        results.data.forEach(elem => {
            let result = document.createElement('div')
            result.classList.add('result-element')
            let i = 0
            elem.forEach(e => {
                let child = document.createElement(i === 0 ? 'h2' : 'p')
                child.innerText = e
                result.appendChild(child)
                i += 1
            })
            count += 1

            resultsArray.push(result)
        })

        let nb = document.createElement("p")
        nb.innerHTML = `Nombre de résultats pour "${authorName}": ${count}.`
        resultsCount.appendChild(nb)

        loader.style.display = "none"

        let nbPages = Math.ceil(count / 10)

        for (let i = 0 ; i < nbPages ; i++) {
            let number = document.createElement('p')
            number.innerHTML = i + 1
            if (i === 0)
                number.style.textDecoration = 'underline'
            number.onclick = (e) => {
                document.querySelectorAll('.page-nav div p').forEach(elem => {
                    elem.style.textDecoration = 'none'
                })
                e.target.style.textDecoration = 'underline'
                browseResults(i + 1)
            }
            pagesNumbers.appendChild(number)
        }

        browseResults(1)
        fadeIn()
    }
}

let currentPage = 1

function browseResults(wantedPage) {
    emptyResults()
    currentPage = wantedPage
    wantedPage *= 10
    resultsArray.slice(wantedPage - 10, wantedPage).forEach(result => {
        resultsDiv.appendChild(result)
    })
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
                } else if (document.activeElement === searchBar) {
                    showSuggestions()
                }
                results.data.forEach(elem => {
                    let name = document.createElement('p')
                    name.innerHTML = elem
                    name.addEventListener('click', () => {
                        searchBar.value = elem
                        apiRequestThese(elem)
                    })
                    suggestions.appendChild(name)
                })
            })
    }
}

function switchHam(q) {
    if (q) {
        ham.classList.add('spin-fade')
        cross.classList.remove('spin-fade')
        header.classList.remove('slide-out-header')
        header.classList.add('slide-in-header')
        hamMenu.classList.remove('slide-out')
        hamMenu.classList.add('slide-in')
    } else {
        cross.classList.add('spin-fade')
        ham.classList.remove('spin-fade')
        header.classList.replace('slide-in-header', 'slide-out-header')
        hamMenu.classList.replace('slide-in', 'slide-out')
    }
}

function switchNavTitle(q) {
    if (q) {
        title.style.display = 'block'
    } else if (window.innerWidth < SMALL) {
        title.style.display = 'none'
    }
}

document.addEventListener('click', e => {
    if (e.target.id !== 'suggestions' && e.target !== searchBar && e.target !== searchBarButton) {

        hideSuggestions()
        switchNavTitle(true)

        if (e.target.id === 'hamburger' || e.target.id === 'hamburgerSvg' || e.target.id === 'crossSvg') {
            if (ham.classList.contains('spin-fade'))
                switchHam(false)
            else
                switchHam(true)
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
    switchNavTitle(false)
})

navbarForm.addEventListener('submit', e => {
    e.preventDefault()
    let data = new FormData(navbarForm)
    searchBar.blur()
    apiRequestThese(data.get('author'))
})
