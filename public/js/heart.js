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
            $('.observe').each(function () {
                let heart = $(this).find('#heart');
                if (heart.data('id') === id) {
                    heart.html("favorite")
                }
            })
        })
    });
});
