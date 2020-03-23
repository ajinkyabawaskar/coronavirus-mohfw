    json = JSON.parse(document.getElementById('json').innerText);
    nullJSON = { "num": "-1", "name": "NA", "indian_cases": "0", "foreign_cases": "0", "cured": "0", "deaths": "0" };
    var str = '{"num":"-1",';
    getIndiaData();
    window.onload = function() {
        var e = document.getElementById("typeOfChart");
        var typeOfChart = e.options[e.selectedIndex].value;
        var e = document.getElementById("states");
        var selectedState = e.options[e.selectedIndex].value;
        var dataInJSON = getStateData(selectedState);
        var e = document.getElementById("chartTheme");
        chartTheme = (e.options[e.selectedIndex]).value;
        CanvasJS.addColorSet("BootStrap", ["#17a2b8", "#6c757d", "#28a745", "#dc3545", "#ffc107"]);
        updateRegion(indiaJSON);
        draw(typeOfChart, dataInJSON, chartTheme);
    }

    function getIndiaData() {
        total_indian_cases = 0;
        total_foreign_cases = 0;
        total_cured = 0;
        total_deaths = 0;
        for (i = 0; i < json.length; i++) {
            total_indian_cases += parseInt(json[i].indian_cases);
            total_foreign_cases += parseInt(json[i].foreign_cases);
            total_cured += parseInt(json[i].cured);
            total_deaths += parseInt(json[i].deaths);
        }
        str += '"name":"India","indian_cases":"' + total_indian_cases + '","foreign_cases":"' + total_foreign_cases + '","cured":"' + total_cured + '","deaths":"' + total_deaths + '"}';
        indiaJSON = JSON.parse(str);
        console.log(indiaJSON);
    }

    function updateRegion(dataInJSON) {
        var e = document.getElementById("indianCases");
        e.innerHTML = dataInJSON.indian_cases;
        var e = document.getElementById("foreignCases");
        e.innerHTML = dataInJSON.foreign_cases;
        var e = document.getElementById("regionName1");
        e.innerHTML = ("Total Cases in " + dataInJSON.name);
        var e = document.getElementById("regionName2");
        e.innerHTML = ("Total Cases in " + dataInJSON.name);
        var e = document.getElementById("cured");
        e.innerHTML = (dataInJSON.cured);
        var e = document.getElementById("deaths");
        e.innerHTML = (dataInJSON.deaths);
        total_cases = parseInt(dataInJSON.indian_cases) + parseInt(dataInJSON.foreign_cases);
        var curedPercentage = ((dataInJSON.cured) / (total_cases) * 100).toFixed(0);
        var e = document.getElementById("curedPercentage");
        if (curedPercentage != "NaN")
            e.innerHTML = ("Recovery " + curedPercentage + "%");
        var fatalPercentage = ((dataInJSON.deaths) / (total_cases) * 100).toFixed(0);
        var e = document.getElementById("fatalPercentage");
        if (fatalPercentage != "NaN")
            e.innerHTML = ("Mortality " + fatalPercentage + "%");
    }

    function getStateData(selectedState) {
        for (i = 0; i < json.length; i++) {
            var nameOfStateInJSON = (json[i].name);
            if (selectedState == nameOfStateInJSON) {
                dataInJSON = json[i];
                var found = true;
            }
        }
        if (found)
            return dataInJSON;
        else {
            if (selectedState == "India")
                return indiaJSON;
            else return nullJSON;
        }
    }

    function changeState() {
        var e = document.getElementById("states");
        var selectedState = e.options[e.selectedIndex].value;
        dataInJSON = getStateData(selectedState);
        changeType();
    }

    function changeType() {
        var e = document.getElementById("typeOfChart");
        typeOfChart = e.options[e.selectedIndex].text.toLowerCase();
        updateRegion(dataInJSON);
        draw(typeOfChart, dataInJSON, chartTheme);
    }

    function changeTheme() {
        var e = document.getElementById("chartTheme");
        chartTheme = (e.options[e.selectedIndex]).value;
        changeType();
    }

    function draw(typeOfChart, dataInJSON, chartTheme) {
        var chart = new CanvasJS.Chart("canvas", {
            animationEnabled: true,
            exportEnabled: true,
            theme: chartTheme,
            colorSet: chartTheme,
            title: {
                text: dataInJSON.name,
                fontFamily: "Segoe UI",
                horizontalAlign: "left",
            },
            data: [{
                type: typeOfChart,
                indexLabel: "{x}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontFamily: "Segoe UI",
                dataPoints: [{
                    y: parseInt(dataInJSON.indian_cases),
                    label: "Total Cases",
                    indexLabel: "Total Cases"
                }, {
                    y: parseInt(dataInJSON.foreign_cases),
                    label: "Foreign Nationals",
                    indexLabel: "Foreign Nationals"
                }, {
                    y: parseInt(dataInJSON.cured),
                    label: "Recovered",
                    indexLabel: "Recovered"
                }, {
                    y: parseInt(dataInJSON.deaths),
                    label: "Deaths",
                    indexLabel: "Deaths"
                }, ]
            }]
        });
        chart.render();
    }