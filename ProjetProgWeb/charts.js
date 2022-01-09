let chart1State = false
let chart2State = false
let chart3State = false
let mapState = false

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
    console.log("chargement graphique 1 terminé")
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
    console.log("chargement graphique 2 terminé")
}

function initEstablishmentsChart(results) {
    let data = []

    results.data.forEach(elem => {
        let disc = Object.keys(elem)[0]
        let obj = {
            "name" : disc,
            "y" : parseInt(elem[disc]['number'])
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
    console.log("chargement graphique 3 terminé")
}

function initMapVisuals(data) {
    const H = Highcharts, map = H.maps['countries/fr/fr-all'];

    Highcharts.mapChart('map', {
        "title": {
            "text": "Nombre de thèses soutenues par établissements et leur géolocalisation"
        },
        "tooltip": {
            "pointFormat": "{point.name}<br>" +
                "Thèses: {point.z}"
        },
        "series": [{
            "name": "Basemap",
            "mapData": map,
            "showInLegend": false
        }, {
            "name": "Separators",
            "type": "mapline",
            "showInLegend": false
        }, {
            "type": "mapbubble",
                "dataLabels": {
                "enabled": true,
                "format": "{point.capital}"
            },
            "name": "Établissements",
            "data": data
        }]
    });
    mapState = true
    console.log("chargement map terminé (les ID des établissements sont complètement cassés dans mon jeu de donnée)")
}

function initMap(results) {
    let i = 0
    let result = []

    results.data.forEach(elem => {
        let establishment = Object.keys(elem)[0]
        let id = parseInt(elem[establishment]['ID'])
        let number = parseInt(elem[establishment]['number'])

        fetch(`https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&q=${id}&rows=10&fileds=identifiant_idref&fields=identifiant_idref,coordonnees`)
            .then(response => response.json())
            .then(data => {
                if (data["records"].length > 0) {
                    let coordinates =  data["records"][0]["fields"]["coordonnees"]
                    let obj = {
                        "name": establishment,
                        "lat": coordinates[0],
                        "lon": coordinates[1],
                        "z": number
                    }
                    result.push(obj)
                }
                i += 1
                if (i === results.data.length) {
                    initMapVisuals(result)
                }
            })
    })
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
        initMap(results)
    })

    let waitForChartsToLoad = setInterval(function() {
        if (chart1State && chart2State && chart2State && mapState) {
            chartsState = true
            clearInterval(waitForChartsToLoad);
        }
    }, 100)
}
