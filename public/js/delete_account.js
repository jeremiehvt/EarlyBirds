$(document).ready(function() {
    $('.js-delete-account').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();

        $.ajax({
            method: 'DELETE',
            url: $link.attr('href')
        }).done(function () {
            window.location = "/logout";
        });
    });
});
