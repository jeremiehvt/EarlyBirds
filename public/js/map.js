$(function() {

    let map = L.map('map')
                 .setView([51.505,
                           -0.09],
                          5
                 );

    L.tileLayer('https://api.mapbox.com/styles/v1/neokiller113/cjgpehvma00992sqmhyxveaa6/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}',
                {
                    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox.streets',
                    accessToken: 'pk.eyJ1IjoibmVva2lsbGVyMTEzIiwiYSI6ImNqZ2h2c2xxMzBsbm0ycWsxemJ6YnNpZXEifQ.PiGeZsNjVNyo1G80Y1KD4Q'
                }
    )
     .addTo(map);

    let domainUrl = document.location.origin;//set base uri origin to ajax request !!!!!!

    //INIT_GEOLOCATION

    function success(pos) {
        let cLong = pos.coords.longitude;
        let cLat = pos.coords.latitude;

        map.flyTo([cLat,cLong], 10);
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

    $().ready(function () {
        $.getJSON(domainUrl + '/recherche-les-dernieres-observations',
                  function(data) {

                      let i = 0;
                      data.forEach(function (datas) {

                          i++;

                          let dateObs = new Date(datas.obsDate.date);
                          let refName;
                          if (datas.ref == null) {
                              refName ="NC";
                          } else {
                              refName = datas.ref.nomComplet;
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

                          let nickname;

                          if (datas.author.nickname === null) {
                              nickname = "NC";
                          } else {
                              nickname = datas.author.nickname;
                          }

                          let layer = L.marker([datas.latitude,datas.longitude]);
                          let tab = [];
                          tab.push(layer);
                          L.featureGroup(tab).bindPopup(
                              '<div id="popupMap">' +
                              '<img id="birdPopup" class="circle responsive-img" src="'+ datas.img +'"/>' +
                              '<br><span id="birdName">'+ refName +'</span>'+
                              '<br>Observé le '+ DD +' '+ MM +' '+ YY +
                              '<br><span id="author">'+ nickname +'</span>'+
                              '<br><br>Latitude : '+ datas.latitude + '<br>Longitude :'+ datas.longitude +
                              '<br><br><a href="'+ domainUrl +'/voir-observation-'+ datas.id +'">voir' +
                              ' l\'observation en' +
                              ' détail</a></div>'
                          ).addTo(map);

                      });
              }
          );
    });

});