let navbarForm = document.getElementsByClassName('navbar-form')[0]
let searchbar = document.getElementById('searchbar')
let suggestions = document.getElementById('suggestions')
let searchBarButton = document.getElementById('search-button')
let loader = document.getElementsByClassName('loader')[0]

let authorName = "";

function requestToApi(author) {
    loader.style.display = "block"
    authorName = author
    fetch(`api.php?q=theses&author=${author}`)
        .then(response => response.json())
        .then(data => displayResults(data))
}

// TODO : Faire un système de page plutôt que de charger 10000 résultats en une fois s'il y en a 10000..
function displayResults(results) {
    let count = 0
    results.forEach(function(elem) {
        let result = document.createElement('div')
        result.classList.add('result-element')
        let i = 0
        elem.forEach(function(e) {
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
}

let lastSearch = ""
let last = new Date().getTime()

function realTimeDisplay() {
    let search = document.getElementsByName("author")[0].value
    if (search.length > 3 && (search !== lastSearch || (new Date().getTime() - last) > 500)) {
        lastSearch = search
        last = new Date().getTime()
        fetch(`api.php?q=authors&author=${search}`)
            .then(response => response.json())
            .then(function(data) {
                suggestions.innerHTML = ""
                data.forEach(function(elem) {
                    let outsideTag = document.createElement('a')
                    outsideTag.href = "index.php?author=" + elem
                    let name = document.createElement('p')
                    name.innerHTML = elem
                    outsideTag.appendChild(name)
                    suggestions.appendChild(outsideTag)
                })
            })
    }
}

searchbar.addEventListener('focus', () => {
    navbarForm.style.borderRadius = '15px 15px 0 0'
    suggestions.style.display = 'block'
    searchBarButton.style.boxShadow = 'none'
    searchBarButton.classList.remove('animation-in')
    searchBarButton.classList.add('animation-out')
});
searchbar.addEventListener('focusout', () => {
    if (!suggestions === document.activeElement) {
        navbarForm.style.borderRadius = '15px'
        suggestions.style.display = 'none'
        searchBarButton.style.boxShadow = 'rgba(0, 0, 0, 0.15) 4px 2px 5px'
        searchBarButton.classList.remove('animation-out')
        searchBarButton.classList.add('animation-in')
    }
});
