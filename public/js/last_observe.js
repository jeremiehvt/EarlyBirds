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
            $link.find('.material-icons').show();
            $link.find('#ajaxLoading').hide();
            $link.parent().find('.js-like-observe-count').html(data.hearts);

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
            $('.observe').each(function () {
                let heart = $(this).find('#heart');
                if (heart.data('id') === id) {
                    heart.html("favorite")
                }
            })
        })
    });

    $('.observe').hide(function () {
        $('.observe:lt(9)').show()
    });

    $.getJSON(
        $('.autocomplete').data('url'),
        function (data) {
            hideAjaxLoader();
            $('input.autocomplete').autocomplete({
                data: data,
                onAutocomplete: function (data) {
                    $('.card-image > span').each(function () {
                        let nomVern = $(this).html();
                        let lbNom = $(this).data('lbnom');
                        if (nomVern.replace(/ /g,'') === data.replace(/ /g,'') || lbNom.replace(/ /g,'') === data.replace(/ /g,'')) {
                            $('.observe').hide();
                            $(this).closest('.observe').show();
                        }
                    })
                }
            });
        }
    );

    $('input.autocomplete').keyup(function () {
        if (this.value === "") {
            $('.observe').each(function () {
                $(this).show();
                $('.observe:gt(8)').hide();
            })
        }
    });

});

function hideAjaxLoader() {
    $('.ObserveAjaxLoader').fadeOut('normal', function () {
        $(this).hide();
    });
}
