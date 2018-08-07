$(function() {

    let map = L.map('mapid').setView([51.505, -0.09], 5);

    L.tileLayer('https://api.mapbox.com/styles/v1/neokiller113/cjgpehvma00992sqmhyxveaa6/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoibmVva2lsbGVyMTEzIiwiYSI6ImNqZ2h2c2xxMzBsbm0ycWsxemJ6YnNpZXEifQ.PiGeZsNjVNyo1G80Y1KD4Q'
    }).addTo(map);
    /*
     $('<ul class="birdsList"></ul>').insertAfter($('#observe_ref'));

     $('#observe_ref').keyup(function() {
     if ($('#observe_ref').val().length > 3) {

     console.log($('.birdsList li').length);

     if ($('.birdsList li').length > 0) {
     $('.birdsList li').remove();
     }

     //ajax call
     $.getJSON(
     'http://127.0.0.1:8000/recherche-'+$('#observe_ref').val(),
     function(data) {
     //reading of the json object as a table
     //and implementation under the field

     let birdsID = 0;
     data.forEach(function(datas) {
     birdsID++;
     $('<li id="birds'+ birdsID +'">'+ datas.nomVern +'</li>').prependTo(
     $('.birdsList')
     );
     });
     //select value from the li, put it in input field and destroy li
     let liId = $('.birdsList li');
     for (let i = 0 ; i < liId.length; i++) {
     let idAttr = $(liId[i]);
     $(idAttr).click(function () {
     let value = $(idAttr).text();
     let input = $('#observe_ref');
     input.val(value);
     $('.birdsList li').remove();
     });
     }
     }
     );
     } else {
     //message si recherche imprécise
     if ($('.birdsList li').length > 0) {
     $('.birdsList li').remove();
     }
     $('<p id="message">veuillez affiner votre recherche</p>').prependTo($('#observe_ref'));
     $('#message').fadeOut(4000);
     }
     });
     */

    let domainUrl = document.location.origin;//set base uri origin to ajax request !!!!!!

    $('#update_observe_ref').keyup(function(e) {

        e.preventDefault();
        let searchLgth = $('#update_observe_ref').val().length;
        let searchVal = $('#update_observe_ref').val();


        if (searchLgth === 1) {
            $.ajax({
               url: domainUrl + "/recherche-" + searchVal,
               cache: false,
               dataType: "json",
               type: "GET",
               success: function(result) {

                   let birds = [];

                   result.forEach(function (data) {
                       birds.push(data.nomComplet);
                   });

                   if (!birds || !birds.length) return;
                   let suggestions = birds.map(function (item) {
                       return "\"" + item + "\": null";
                   });

                   suggestions = "{" + suggestions + "}";
                   $("#update_observe_ref").autocomplete({

                      data: JSON.parse(suggestions),
                      minLength: 0
                  });
               }
           });
        }

    });


//INIT_GEOLOCATION
    let birdMarker;
    let birdMarker2;
    let latitude = $('input#update_observe_latitude');
    let longitude = $('input#update_observe_longitude');

    function newMarker(e) {


        if (map.hasLayer(birdMarker) || birdMarker !== undefined) {
            birdMarker.remove();
        }

        if (birdMarker2 === undefined) {

            birdMarker2 = L.marker(e.latlng).addTo(map);
            birdMarker2.addTo(map);

            let cLat = e.latlng.lat;
            latitude.val(cLat);

            let cLong = e.latlng.lng;
            longitude.val(cLong);
        }
        birdMarker2.remove();
        birdMarker2 = L.marker(e.latlng).addTo(map);
        birdMarker2.addTo(map);

        let cLat = e.latlng.lat;
        latitude.val(cLat);

        let cLong = e.latlng.lng;
        longitude.val(cLong);

    }

    function initMarker(pos) {
        let cLong = pos.coords.longitude;
        let cLat = pos.coords.latitude;

        if (latitude.val() === "" && longitude.val() === "") {
            latitude.val(cLat);
            longitude.val(cLong);

            birdMarker = L.marker([latitude.val(),longitude.val()]).addTo(map);
            birdMarker.bindPopup('<p id="popupMap">cliquez sur la carte</br>pour situer' +
                                 ' </br>l\'observation.</p>').openPopup();
            birdMarker.addTo(map);
            map.flyTo([latitude.val(),longitude.val()], 10);
        } else {
            birdMarker = L.marker([latitude.val(),longitude.val()]).addTo(map);
            let nickname;
            $.ajax({
                       url: domainUrl + "/search/"+latitude.val()+"/"+longitude.val(),
                       cache: false,
                       dataType: "json",
                       type: "GET",
                       success: function(result) {

                           let dateObs = new Date(result[0].obsDate.date);
                           let ref = result[0].ref;
                           let refName;
                           if (ref == null) {
                               refName ="NC";
                           } else {
                               refName = result[0].ref.nomComplet;
                           }

                           let YY = dateObs.getFullYear();
                           let DD = dateObs.getDate();
                           let MM;

                           switch(dateObs.getMonth()){
                               case 1: MM = "Janvier";
                                   break;
                               case 2: MM = "Février";
                                   break;
                               case 3: MM = "Mars";
                                   break;
                               case 4: MM = "Avril";
                                   break;
                               case 5: MM = "Mai";
                                   break;
                               case 6: MM = "Juin";
                                   break;
                               case 7: MM = "Juillet";
                                   break;
                               case 8: MM = "Août";
                                   break;
                               case 9: MM = "Septembre";
                                   break;
                               case 10: MM = "Octobre";
                                   break;
                               case 11: MM = "Novembre";
                                   break;
                               case 12: MM = "Décembre";
                                   break;
                           }

                           if (result[0].author.nickname === null) {
                               nickname = "NC";
                           } else {
                               nickname = result[0].author.nickname;
                           }

                           birdMarker.bindPopup(
                               '<div id="popupMap">' +
                               '<img id="birdPopup" class="circle responsive-img" src="'+ result[0].img +'"/>' +
                               '<br><span id="birdName">'+ refName +'</span>'+
                               '<br>Observé le '+ DD +' '+ MM +' '+ YY +
                               '<br><span id="author">'+ nickname +'</span>'+
                               '<br><br>Latitude : '+ result[0].latitude + '<br>Longitude :'+ result[0].longitude +
                               '</div>'
                           ).openPopup();
                       }
                   });

            birdMarker.addTo(map);
            map.flyTo([latitude.val(),longitude.val()], 10);
        }
    }

    function success(pos) {
        initMarker(pos);
    }

    function error(err) {
        switch (err.code) {
            case err.TIMEOUT:
                cLat.val('temps de chargement dépassé');
                cLong.val('temps de chargement dépassé');
                break;

            case err.PERMISSION_DENIED:
                cLat.val('permission désaprouvée');
                cLong.val('permission désaprouvée');
                break;

            case err.POSITION_UNAVAILABLE:
                cLat.val('position indéterminée');
                cLong.val('position indéterminée');
                break;

            case err.UNKNOWN_ERRROR:
                cLat.val('erreur inconnue');
                cLong.val('erreur inconnue');
                break;
        }
    }

    let geo = navigator.geolocation;
    geo.getCurrentPosition(success,error,{maximumAge:10000,enableHighAccuracy:true});

//END_GEOLOCATION

//SET_UP_POSITION_ON_MAP_AFTER_CLICK

    map.on('click', newMarker);

//END_SET_UP_POSITION_ON_MAP_AFTER_CLICK

//SET_UP_COORDS_FROM_FORM
    longitude.on('blur',function () {
        let lat = latitude.val();
        let long = longitude.val();

        if (birdMarker2 === undefined) {
            birdMarker2 = L.marker([lat,long]).addTo(map);
            birdMarker2.addTo(map);
        }
        birdMarker2.remove();
        birdMarker2 = L.marker([lat,long]).addTo(map);
        birdMarker2.addTo(map);
    });

    latitude.on('blur', function () {
        let lat = latitude.val();
        let long = longitude.val();

        if (birdMarker2 === undefined) {

            birdMarker2 = L.marker([lat,long]).addTo(map);
            birdMarker2.addTo(map);
        }

        birdMarker2.remove();
        birdMarker2 = L.marker([lat,long]).addTo(map);
        birdMarker2.addTo(map);
    });

    //flash message after valide or update obs and auto scrolling
    let msgUn = $('.flash-notice');
    let divUpBtn = $('#divUpBtn');
    let divSubBtn = $('#divSubBtn');
    let message = $('.message');
    let url = document.location.origin +'/saisir-observation#mes1';

    if (msgUn.text().length > 0) {
        document.location.assign(url);
        divSubBtn.hide();
        divUpBtn.hide();
        message.fadeOut(9000, function () {
            divSubBtn.show();
            divUpBtn.show();
        });
    }

});
