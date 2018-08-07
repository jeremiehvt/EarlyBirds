$(function() {
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

    $('.js-like-post').on('click', function (e) {
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
            $link.parent().find('.js-like-post-count').html(data.hearts);

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

    let url = $('#observeheart').data('url');
    $.getJSON(url, function (data) {
        $.each(data, function (key, val) {
            let id = val;
            $('.observecard').each(function () {
                let heart = $(this).find('#observeheart');
                if (heart.data('id') === id) {
                    heart.html("favorite")
                }
            })
        })
    });

    let postUrl = $('#postheart').data('url');
    $.getJSON(postUrl, function (data) {
        $.each(data, function (key, val) {
            if ($('#postheart').data('id') === val) {
                $('#postheart').html("favorite");
            }
        })
    });
});
