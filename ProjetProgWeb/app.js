
function requestToApi(author) {
    fetch(`api.php?author=${author}`)
        .then(response => response.json())
        .then(data => displayResults(data))
}

function displayResults(results) {
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

        document.getElementById('results').appendChild(result)

    })
}