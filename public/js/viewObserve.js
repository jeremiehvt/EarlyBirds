let index = $('#mapContainer').data('index');
let lat = $('#mapContainer').data('lat');
let long = $('#mapContainer').data('long');

let mymap = L.map('obsMap').setView([lat, long], 11);

L.marker([lat, long]).addTo(mymap);

L.tileLayer(
    'https://api.mapbox.com/styles/v1/mapbox/outdoors-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmVva2lsbGVyMTEzIiwiYSI6ImNqZ2h2c2xxMzBsbm0ycWsxemJ6YnNpZXEifQ.PiGeZsNjVNyo1G80Y1KD4Q', {
        maxZoom: 18,
        minZoom: 6,
        id: 'mapbox.streets',
    }).addTo(mymap);

document.addEventListener('DOMContentLoaded', function() {
    let observeImg = document.querySelectorAll('.materialboxed');
    let observeImagesAnim = M.Materialbox.init(observeImg, {
        onOpenStart: function () {
            $('#obsMap').hide();
        },
        onCloseStart: function () {
            $('#obsMap').show();
        }
    });
});

$(document).ready(function() {

    $('.js-like-observe').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {
            $link.parent().find('.js-like-observe-count').html(data.hearts);
            $link.find('.material-icons').show();
            $link.find('#ajaxLoading').hide();

            switch ($link.find('.material-icons').html()) {
                case "favorite_border":
                    $link.find('.material-icons').html('favorite');
                    break;
                case "favorite":
                    $link.find('.material-icons').html('favorite_border');
                    break;
            }
        });
    });

    let url = $('#heart').data('url');
    $.getJSON(url, function (data) {
        $.each(data, function (key, val) {
            let id = val;
            if ($('#heart').data('id') === id) {
                $('#heart').html("favorite")
            }
        })
    });

    $('.js-taxrefrang').each(function () {
        $(this).html('<b>Rang : </b>' + rang($(this).data('rang')));
    });

    $('.js-taxrefhab').each(function () {
        $(this).html('<b>Habitat : </b>' + habitat($(this).data('hab')));
    });

    $('.js-taxref-fr').each(function () {
        $(this).html(lb($(this).data('fr')) + " en France métropolitaine");
    });

    $('.js-taxref-gf').each(function () {
        $(this).html(lb($(this).data('gf')) + " en Guyane française");
    });

    $('.js-taxref-mar').each(function () {
        $(this).html(lb($(this).data('mar')) + " à la Martinique");
    });

    $('.js-taxref-gua').each(function () {
        $(this).html(lb($(this).data('gua')) + " à la Guadeloupe");
    });

    $('.js-taxref-sm').each(function () {
        $(this).html(lb($(this).data('sm')) + " à Saint-Martin");
    });

    $('.js-taxref-spm').each(function () {
        $(this).html(lb($(this).data('spm')) + " à Saint-Pierre et Miquelon");
    });

    $('.js-taxref-may').each(function () {
        $(this).html(lb($(this).data('may')) + " à Mayotte");
    });

    $('.js-taxref-epa').each(function () {
        $(this).html(lb($(this).data('epa')) + " aux Îles Éparses");
    });

    $('.js-taxref-reu').each(function () {
        $(this).html(lb($(this).data('reu')) + " à la Réunion");
    });

    $('.js-taxref-sa').each(function () {
        $(this).html(lb($(this).data('sa')) + " aux îles subantarctiques");
    });

    $('.js-taxref-ta').each(function () {
        $(this).html(lb($(this).data('ta')) + " en Terre Adélie");
    });

    $('.js-taxref-nc').each(function () {
        $(this).html(lb($(this).data('nc')) + " en Nouvelle-Calédonie");
    });

    $('.js-taxref-wf').each(function () {
        $(this).html(lb($(this).data('wf')) + " à Wallis et Futuna");
    });

    $('.js-taxref-pf').each(function () {
        $(this).html(lb($(this).data('pf')) + " en Polynésie française");
    });

    $('.js-taxref-cli').each(function () {
        $(this).html(lb($(this).data('cli')) + " à Clipperton");
    });

    $('.js-taxref-sb').each(function () {
        $(this).html(lb($(this).data('sb')) + " à Saint-Barthélemy");
    });
});

function lb(rang) {
    switch (rang) {
        case "A":
            return "Absente";
            break;
        case "B":
            return "Accidentelle / Visiteuse";
            break;
        case "C":
            return "Cryptogène";
            break;
        case "D":
            return "Douteuse";
            break;
        case "E":
            return "Endémique";
            break;
        case "F":
            return "Trouvée en fouille";
            break;
        case "I":
            return "Introduite";
            break;
        case "J":
            return "Introduite envahissante";
            break;
        case "M":
            return "Domestique / Introduite non établie";
            break;
        case "P":
            return "Présente";
            break;
        case "Q":
            return "Mentionnée par erreur";
            break;
        case "S":
            return "Subendémique";
            break;
        case "W":
            return "Disparue";
            break;
        case "X":
            return "Éteinte";
            break;
        case "Y":
            return "Introduite éteinte";
            break;
        case "Z":
            return "Endémique éteinte";
            break;
    }
}

function rang(rang) {
    switch (rang) {
        case "KD":
            return "Règne";
            break;
        case "PH":
            return "Embranchement";
            break;
        case "CL":
            return "Classe";
            break;
        case "OR":
            return "Ordre";
            break;
        case "FM":
            return "Famille";
            break;
        case "GN":
            return "Genre";
            break;
        case "AGES":
            return "Agrégat";
            break;
        case "ES":
            return "Espèce";
            break;
        case "SSES":
            return "Sous-espèce";
            break;
        case "CVAR":
            return "Convariété";
            break;
        case "VAR":
            return "Variété";
            break;
        case "FO":
            return "Forme";
            break;
        case "SSFO":
            return "Sous-forme";
            break;
        case "RACE":
            return "Race";
            break;
        case "HYB":
            return "Hybride";
            break;
    }
}

function habitat(habitat) {
    switch (habitat) {
        case 1:
            return "Marin";
            break;
        case 2:
            return "Eau douce";
            break;
        case 3:
            return "Terrestre";
            break;
        case 4:
            return "Marin & Eau douce";
            break;
        case 5:
            return "Marin & Terrestre";
            break;
        case 6:
            return "Eau saumâtre";
            break;
        case 7:
            return "Continental (terrestre et/ou eau douce)";
            break;
        case 8:
            return 'Continental (terrestre et eau douce)';
            break;
    }
}