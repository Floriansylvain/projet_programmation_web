let authorName = "";

function requestToApi(author) {
    authorName = author
    fetch(`api.php?author=${author}`)
        .then(response => response.json())
        .then(data => displayResults(data))
}

function displayResults(results) {
    document.getElementsByClassName('loader')[0].style.display = "block"
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
    document.getElementsByClassName('loader')[0].style.display = "none"
}