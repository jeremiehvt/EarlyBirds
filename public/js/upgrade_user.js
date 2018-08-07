$(document).ready(function() {
    $('.js-upgrade-user').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let id = $(this).data('id');

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {
            $link.find('.material-icons').show();
            $link.find('#ajaxLoading').hide();

            $('.modal').modal('close');
            let $roleCollumn = $('.userContainer-' + id).find('.userRole');
            let $upgradeBtn = $('.userContainer-' + id).find('.js-upgradeBtn');
            let $downgradeBtn = $('.userContainer-' + id).find('.js-downgradeBtn');
            let role = $roleCollumn.html().trim();
            if (role === "Utilisateur") {
                $roleCollumn.fadeOut('normal', function () {
                    $roleCollumn.html("Naturaliste").show();
                    $downgradeBtn.fadeIn('normal');
                    $upgradeBtn.show();
                });
            }
            if (role === "Naturaliste") {
                $roleCollumn.fadeOut('normal', function () {
                    $roleCollumn.html("ADMIN").show();
                    $downgradeBtn.show();
                    $upgradeBtn.fadeOut('normal');
                });
            }
        });
    });
});
