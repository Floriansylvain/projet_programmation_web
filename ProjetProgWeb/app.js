const SMALL = 576
const MEDIUM = 768
const LARGE = 992
const EXTRA_LARGE = 1200

const RESULTS_NUMBER = 10

const urlParams = new URLSearchParams(window.location.search);

let navbarForm = document.querySelector('.navbar-form')
let searchBar = document.querySelector('#searchbar')
let searchBarButton = document.querySelector('#search-button')
let suggestions = document.querySelector('#suggestions')
let loader = document.querySelector('.loader')
let error = document.querySelector('#error')
let errorMessage = document.querySelector('#error-message')
let errorButton = document.querySelector('#error-button')
let hamMenu = document.querySelector('#hamburger-menu')
let title = document.querySelector('#title')
let ham = document.querySelector('#hamburgerSvg')
let cross = document.querySelector('#crossSvg')
let pagesNumbersContainer = document.querySelector('.page-nav')
let pagesNumbers = document.querySelector('.page-nav div')
let resultsDiv = document.querySelector('#results')
let resultsCount = document.querySelector('#results-count')
let filters = document.querySelectorAll('.filters p')

function sanitize(chain) {
    return chain.replace(/[^a-zA-Z0-9\- ]/g,'')
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
    resultsDiv.innerHTML = ""
    if (withCount)
        resultsCount.innerHTML = ""
}

let searchString = "";
let lastRequest = null
let queryOption = null

function apiRequestThese(search, offset) {
    hideSuggestions()
    if (lastRequest === null || (new Date().getTime() - lastRequest) > 1000) {
        lastRequest = new Date().getTime()
        emptyResults(true)
        pagesNumbers.innerHTML = ""
        loader.style.display = "block"
        searchString = sanitize(search)
        fetch(`api.php?q=theses&search=${searchString}&option=${queryOption}&offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                fetch(`api.php?q=count&search=${searchString}&option=${queryOption}&offset=0`)
                    .then(response => response.json())
                    .then(aCount => displayResults(data, aCount.data[0]))
            })
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

function updatePageNumber(number) {
    pagesNumbers.childNodes.forEach(elem => {
        if (parseInt(elem.innerHTML) === number) {
            elem.style.fontWeight = "bold"
            elem.style.textDecoration = "underline"
            pagesNumbers.scrollLeft += elem.getBoundingClientRect().left -
                pagesNumbers.getBoundingClientRect().left -
                (pagesNumbers.offsetWidth / 2) + (elem.offsetWidth / 2)
        } else {
            elem.style.textDecoration = "normal"
            elem.style.textDecoration = "none"
        }
    })
}

function focusResults(result) {
    resultsDiv.childNodes.forEach(elem => {
        let elemContent = elem.querySelector('.element-content')
        if (result !== elem) {
            elemContent.style.display = 'none'
        } else {
            let display = elemContent.style.display
            elemContent.style.display = display === 'none' || display === '' ? 'block' : 'none'
        }
    })
    fadeIn()
}

let resultsArray = []
let count = 0
let nbPages = 0
let currentPage = null

function displayResults(results, aCount) {
    if (results.status === 400) {
        loader.style.display = "none"
        error.classList.remove("fade-out");
        error.classList.add("fade-in");
        errorMessage.innerHTML = results.message
        pagesNumbersContainer.style.display = 'none'
    } else if (results.status === 200) {
        count = aCount
        resultsArray = []
        pagesNumbersContainer.style.display = 'flex'
        results.data.forEach(elem => {
            let result = document.createElement('div')
            result.classList.add('result-element')
            let i = 0

            let header = document.createElement('div')

            let qAuthor = elem[0]
            let author = document.createElement('h3')
            let pre_replacement = new RegExp(searchString, 'gi').exec(qAuthor)
            author.innerHTML = qAuthor.replace(pre_replacement, `<mark>${pre_replacement}</mark>`)

            let qTitle = elem[2]
            let title = document.createElement('p')
            pre_replacement = new RegExp(searchString, 'gi').exec(qTitle)
            title.innerHTML = qTitle.replace(pre_replacement, `<mark>${pre_replacement}</mark>`)

            let firstElement = document.createElement('div')
            firstElement.classList.add('result-element-header')

            let onlineButton = document.createElement('button')
            onlineButton.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path d=\"M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 16.057v-3.057h2.994c-.059 1.143-.212 2.24-.456 3.279-.823-.12-1.674-.188-2.538-.222zm1.957 2.162c-.499 1.33-1.159 2.497-1.957 3.456v-3.62c.666.028 1.319.081 1.957.164zm-1.957-7.219v-3.015c.868-.034 1.721-.103 2.548-.224.238 1.027.389 2.111.446 3.239h-2.994zm0-5.014v-3.661c.806.969 1.471 2.15 1.971 3.496-.642.084-1.3.137-1.971.165zm2.703-3.267c1.237.496 2.354 1.228 3.29 2.146-.642.234-1.311.442-2.019.607-.344-.992-.775-1.91-1.271-2.753zm-7.241 13.56c-.244-1.039-.398-2.136-.456-3.279h2.994v3.057c-.865.034-1.714.102-2.538.222zm2.538 1.776v3.62c-.798-.959-1.458-2.126-1.957-3.456.638-.083 1.291-.136 1.957-.164zm-2.994-7.055c.057-1.128.207-2.212.446-3.239.827.121 1.68.19 2.548.224v3.015h-2.994zm1.024-5.179c.5-1.346 1.165-2.527 1.97-3.496v3.661c-.671-.028-1.329-.081-1.97-.165zm-2.005-.35c-.708-.165-1.377-.373-2.018-.607.937-.918 2.053-1.65 3.29-2.146-.496.844-.927 1.762-1.272 2.753zm-.549 1.918c-.264 1.151-.434 2.36-.492 3.611h-3.933c.165-1.658.739-3.197 1.617-4.518.88.361 1.816.67 2.808.907zm.009 9.262c-.988.236-1.92.542-2.797.9-.89-1.328-1.471-2.879-1.637-4.551h3.934c.058 1.265.231 2.488.5 3.651zm.553 1.917c.342.976.768 1.881 1.257 2.712-1.223-.49-2.326-1.211-3.256-2.115.636-.229 1.299-.435 1.999-.597zm9.924 0c.7.163 1.362.367 1.999.597-.931.903-2.034 1.625-3.257 2.116.489-.832.915-1.737 1.258-2.713zm.553-1.917c.27-1.163.442-2.386.501-3.651h3.934c-.167 1.672-.748 3.223-1.638 4.551-.877-.358-1.81-.664-2.797-.9zm.501-5.651c-.058-1.251-.229-2.46-.492-3.611.992-.237 1.929-.546 2.809-.907.877 1.321 1.451 2.86 1.616 4.518h-3.933z\"/></svg>"
            if (elem[14] === 'no') {
                onlineButton.disabled = true
            } else {
                onlineButton.onclick = function() {
                    window.open('https://www.theses.fr/' + elem[13] + '/document', ',_blank')
                }
            }

            firstElement.append(author, onlineButton)
            header.append(firstElement, title)

            let content = document.createElement('div')
            content.classList.add('element-content')

            elem.forEach(e => {
                if (i > 3 && i !== 14) {
                    let child = document.createElement('p')
                    let pre_replacement = new RegExp(searchString, 'gi').exec(e)
                    child.innerHTML = e.replace(pre_replacement, `<mark>${pre_replacement}</mark>`)
                    content.appendChild(child)
                } i += 1
            })

            header.addEventListener('click', () => {
                focusResults(result)
            })

            result.append(header, content)

            resultsArray.push(result)
        })

        let nb = document.createElement("p")
        nb.innerHTML = `Nombre de résultats en ${queryOption} pour "${searchString}": 
            ${new Intl.NumberFormat('fr-FR', { maximumSignificantDigits: 3 }).format(count)}.`
        resultsCount.appendChild(nb)

        loader.style.display = "none"

        nbPages = Math.ceil(count / RESULTS_NUMBER)

        for (let i = 0 ; i < nbPages ; i++) {
            let number = document.createElement('p')
            number.innerHTML = i + 1
            if (i === 0)
                number.style.textDecoration = 'underline'
            number.onclick = () => {
                browseResults(i + 1)
            }
            pagesNumbers.appendChild(number)
        }

        if (count < 1) {
            pagesNumbersContainer.style.display = 'none'
        }

        resultsArray.forEach(result => {
            resultsDiv.appendChild(result)
        })

        currentPage = (parseInt(urlOffset) + RESULTS_NUMBER) / RESULTS_NUMBER
        updatePageNumber(currentPage)
        fadeIn()
    }
}

function submitForm(offset) {
    navbarForm.querySelector('input[name="option"]').value = queryOption
    navbarForm.querySelector('input[name="offset"]').value = offset
    navbarForm.submit()
}

function browseResults(wantedPage) {
    if (wantedPage > 0 && wantedPage < nbPages + 1) {
        let offset = (wantedPage * RESULTS_NUMBER) - RESULTS_NUMBER
        submitForm(offset)
    }
}

let lastSearch = ""
let lastSuggestion = new Date().getTime()
let suggestionsDisplayed = false

function realTimeDisplay() {
    let search = document.querySelector('input[name=\'search\']').value
    search = sanitize(search)
    if (search.length > 3 && (search !== lastSearch && (new Date().getTime() - lastSuggestion) > 500)) {
        lastSearch = search
        lastSuggestion = new Date().getTime()
        fetch(`api.php?q=suggestion&search=${search}&option=${queryOption}&offset=0`)
            .then(response => response.json())
            .then(results => {
                if (results.data) {
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
                            apiRequestThese(elem, 0)
                        })
                        suggestions.appendChild(name)
                    })
                }
            })
    }
}

function switchHam(q) {
    if (q) {
        ham.classList.add('spin-fade')
        cross.classList.remove('spin-fade')
        hamMenu.classList.remove('slide-out')
        hamMenu.classList.add('slide-in')
    } else {
        cross.classList.add('spin-fade')
        ham.classList.remove('spin-fade')
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

function updateFilter(f) {
    if (f.includes('f-')) {
        queryOption = f.substring(2)
    } else {
        queryOption = f
    }

    filters.forEach(elem => {
        elem.style.boxShadow = 'none'
    })

    document.querySelector('#f-' + queryOption).style.boxShadow = 'inset rgba(0, 0, 0, 0.40) 0 0 5px'
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

        if (e.target === errorButton || e.target === errorButton.firstElementChild) {
            error.classList.replace('fade-in', 'fade-out')
        }

        let toggleSwitch = null
        let toggleSwitchParent = null
        if (e.target.classList.contains('slider')) {
            toggleSwitch = e.target
            toggleSwitchParent = e.target.parentNode
        } else if (e.target.classList.contains('toggle-switch')) {
            toggleSwitch = e.target.firstElementChild
            toggleSwitchParent = e.target
        }
        if (toggleSwitch !== null && toggleSwitchParent !== null) {
            if (toggleSwitch.classList.contains('untoggle')) {
                toggleSwitchParent.style.backgroundColor = '#FFF'
                toggleSwitch.classList.replace('untoggle', 'toggle')
            } else {
                toggleSwitchParent.style.backgroundColor = '#ECECEC'
                toggleSwitch.classList.replace('toggle', 'untoggle')
            }
        }

        if (e.target.id.toString().includes('f-')) {
            updateFilter(e.target.id)
        }
    }
})

searchBar.addEventListener('focus', () => {
    switchNavTitle(false)
})

navbarForm.addEventListener('submit', e => {
    e.preventDefault()
    submitForm(0)
})

let urlSearch = urlParams.get('search')
let urlOption = urlParams.get('option')
let urlOffset = urlParams.get('offset')

updateFilter(urlOption ? urlOption : 'f-auto')

if (urlSearch && urlOption && urlOffset) {
    searchBar.value = urlSearch
    apiRequestThese(urlSearch, urlOffset)
}
