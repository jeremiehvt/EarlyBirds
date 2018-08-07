$( document ).ready(function() {
    $('#footer > div:nth-child(2) > div > form > div:nth-child(2) > button').click(function (e) {
        e.preventDefault();
        let mail = $('.footernewsletter').val();
        let $helperText = $('#footer > div:nth-child(2) > div > form > div.input-field.inline > span');

        $.ajax({
            method: 'POST',
            url: "/newsletter/"+mail,
        }).done(function (data) {
            if (data === true) {
                $helperText.attr('data-error', "Vous êtes déjà enregistré à la newsletter");
                $('#email_inline.footernewsletter').removeClass('valid').addClass('invalid');
                $helperText.show().delay(5000).fadeOut('normal');
            } else {
                $helperText.attr('data-success', "Merci pour votre inscription à la newsletter");
                $helperText.show().delay(5000).fadeOut('normal');
            }
        });
    });
});