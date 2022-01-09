let chart1State = false
let chart2State = false
let chart3State = false

function initYearsChart(results) {
    let categories = []
    let online = []
    let offline = []
    let total = []

    results.data.forEach(elem => {
        let year = Object.keys(elem)[0]
        categories.push(year)
        online.push(parseInt(elem[year].online))
        offline.push(parseInt(elem[year].offline))
        total.push(parseInt(elem[year].online) + parseInt(elem[year].offline))
    })

    Highcharts.chart('years', {
        "title": {
            "text": "Nombre de thèses et leurs disponibilités en ligne selon leurs années de soutenance"
        },
        "xAxis": {
            "categories": categories,
            "title": {
                "text": "Années"
            }
        },
        "yAxis": {
            "title": {
                "text": "Thèses"
            }
        },
        "tooltip": {
            "shared": true,
            "valueSuffix": " thèses"
        },
        "credits": {
            "enabled": false
        },
        "series": [
            {
                "name": "Total",
                "data": total,
                "color": "#f4d03f",
                "dashStyle": "longdash",
                "marker": {
                    "enabled": false
                }
            },
            {
                "name": "En ligne",
                "data": online,
                "color": "#5dade2",
                "marker": {
                    "enabled": false
                }
            },
            {
                "name": "Hors ligne",
                "data": offline,
                "color": "#cd6155",
                "marker": {
                    "enabled": false
                }
            }
        ]
    })

    chart1State = true
}

function initDisciplinesChart(results) {
    let data = []

    results.data.forEach(elem => {
        let disc = Object.keys(elem)[0]
        let obj = {
            "name" : disc,
            "y" : parseInt(elem[disc])
        }
        data.push(obj)
    })

    Highcharts.chart('disciplines', {
        "chart": {
            "type": "pie"
        },
        "title": {
            "text": "Nombre de thèses par disciplines"
        },
        "plotOptions": {
            "pie": {
                "dataLabels": {
                    "enabled": (window.innerWidth >= SMALL)
                },
                "showInLegend": (window.innerWidth < SMALL)
            }
        },
        "credits": {
            "enabled": false
        },
        "series": [
            {
                "name": "Thèses",
                "colorByPoint": true,
                "data": data
            }
        ]
    })

    chart2State = true
}

function initEstablishmentsChart(results) {
    let data = []

    results.data.forEach(elem => {
        let disc = Object.keys(elem)[0]
        let obj = {
            "name" : disc,
            "y" : parseInt(elem[disc])
        }
        data.push(obj)
    })

    Highcharts.chart('establishments', {
        "chart": {
            "type": "pie"
        },
        "title": {
            "text": "Nombre de thèses soutenues par établissements"
        },
        "plotOptions": {
            "pie": {
                "dataLabels": {
                    "enabled": (window.innerWidth >= SMALL)
                },
                "showInLegend": (window.innerWidth < SMALL)
            }
        },
        "credits": {
            "enabled": false
        },
        "series": [
            {
                "name": "Thèses",
                "colorByPoint": true,
                "data": data
            }
        ]
    })

    chart3State = true
}

function initCharts(search, option) {
    fetch(`api.php?q=years&search=${search}&option=${option}&offset=0`)
    .then(response => response.json())
    .then(results => {
        initYearsChart(results)
    })

    fetch(`api.php?q=disciplines&search=${search}&option=${option}&offset=0`)
    .then(response => response.json())
    .then(results => {
        initDisciplinesChart(results)
    })

    fetch(`api.php?q=establishments&search=${search}&option=${option}&offset=0`)
    .then(response => response.json())
    .then(results => {
        initEstablishmentsChart(results)
    })

    let waitForChartsToLoad = setInterval(function() {
        if (chart1State && chart2State && chart2State) {
            chartsState = true
            clearInterval(waitForChartsToLoad);
        }
    }, 100)
}