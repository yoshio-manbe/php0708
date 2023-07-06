$("submit").click(function(){
    for (let i = 1; i <= 5; i++) {
        const place = $("#place" + i).val();
        const address = $("#address" + i).val();
        const color = $("#color" + i).val();

        const myObj = {
            name: place,
            address: address,
            color: color
        };

        localStorage.setItem("myData" + i, JSON.stringify(myObj));
    };

    location.reload();
})



function loadMapScenario() {
    var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
        /* No need to set credentials if already passed in URL */
        center: new Microsoft.Maps.Location(43.07166, 141.31392),
        zoom: 12
    });

    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
        $('#submit').click(function (event) {
            event.preventDefault();

            for (let i = 1; i <= 5; i++) {
                const place = $("#place" + i).val();
                const address = $("#address" + i).val();
                const color = $("#color" + i).val();

                if (address !== '') {
                    var searchManager = new Microsoft.Maps.Search.SearchManager(map);
                    var requestOptions = {
                        bounds: map.getBounds(),
                        where: address,
                        callback: function (answer, userData) {
                            var location = answer.results[0].location;

                            var pinOptions = {
                                title: place,
                                color: color,
                            };

                            var pin = new Microsoft.Maps.Pushpin(location, pinOptions);
                            map.entities.push(pin);
                        }
                    };
                    searchManager.geocode(requestOptions);
                }
            }
        });
    });
}