$(document).ready(function() {
    $('.js-delete-observe').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();
        let id = $link.data('id');

        $.ajax({
            method: 'DELETE',
            url: $link.attr('href')
        }).done(function () {
            $('.modal').modal('close');
            $('.obsverveContainer-' + id).fadeOut('normal');
            if ($('.js-obs-count').hasClass('active')) {
                let count = parseInt($('.js-obs-count').find('.badge').html());
                $('.js-obs-count').find('.badge').html(count-1);
            }
        });
    });
});
