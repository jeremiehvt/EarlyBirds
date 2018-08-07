$(function(){
    let header = $('#header');
    let headerImg = header.attr('data-bckg');
    header.css('background', 'no-repeat center url("'+ headerImg +'")');

    $('.toggle-heart').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();

        let id = $(this).find('#postheart').data('id');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {

            $link.find('.material-icons').show();
            $link.find('#ajaxLoading').hide();
            $('.head-link').each(function () {

                if ($(this).find('#postheart').data('id') === id) {
                    switch ($(this).find('.head-heart').html()) {
                        case "favorite_border":
                            $(this).find('.head-heart').html('favorite');
                            break;
                        case "favorite":
                            $(this).find('.head-heart').html('favorite_border');
                            break;
                    }
                    $(this).find('.js-like-post-count').html(data.hearts);
                }
            });
        });
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