$(document).ready(function() {

    // Pagination construction
    let toValidateLength = parseInt($('#toValidateObs').data('length'));
    let nbPerPages = 5;
    let toValidatePages = constructPag(toValidateLength, nbPerPages);

    // Init pagination obsreves
    initPageNbr(nbPerPages);

    // Pagination numbers click behavior
    $('.toValidatePagNbr').click(function (e) {
        e.preventDefault();
        let nbClicked = $(this).find('a').html();

        // Update active state
        $('.toValidatePagNbr').each(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });

        // Set clicked to active
        $(this).addClass('active');
        updateObs(parseInt($(this).find('a').html()));

        // Update previous button
        updatePrev(nbClicked);

        // Update next button
        updateNext(nbClicked, toValidatePages);
    });

    // Pagination previous behavior
    $('#toValidatePagStart').click(function () {
        let currentPage = $('.toValidatePagNbr.active a').html();
        let newPage = parseInt(currentPage)-1;
        if (newPage < 1) {
            newPage = 1;
        }

        if (newPage) {
            // Update previous button
            updatePrev(newPage);

            // Update next button
            updateNext(newPage, toValidatePages);

            // Move numbers
            $('.toValidatePagNbr').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
                if (parseInt($(this).find('a').html()) === newPage) {
                    $(this).addClass('active');
                    updateObs(parseInt($(this).find('a').html()));
                }
            });
        }
    });

    // Pagination next behavior
    $('#toValidatePagEnd').click(function () {
        let currentPage = $('.toValidatePagNbr.active a').html();
        let newPage = parseInt(currentPage)+1;
        if (newPage > parseInt(toValidatePages)) {
            newPage = parseInt(toValidatePages);
        }

        if (newPage) {
            // Update previous button
            updatePrev(newPage);

            // Update next button
            updateNext(newPage, toValidatePages);

            // Move numbers
            $('.toValidatePagNbr').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
                if (parseInt($(this).find('a').html()) === newPage) {
                    $(this).addClass('active');
                    updateObs(parseInt($(this).find('a').html()));
                }
            });
        }

    })
});

function constructPag(toValidateLength, nbPerPages) {
    let toValidatePages;
    if (toValidateLength %5 !== 0) {
        toValidatePages = Math.trunc(toValidateLength / nbPerPages)+1;
    } else {
        toValidatePages = toValidateLength / nbPerPages;
    }
    for (let i = 1; i < toValidatePages; i++) {
        $("#toValidatePagEnd").before('<li class="toValidatePagNbr waves-effect"><a href="#!">' + parseInt(i + 1) + '</a></li>');
    }
    if (toValidatePages === 1) {
        $('#toValidatePagEnd').addClass('disabled').removeClass('waves-effect');
    }
    return toValidatePages;
}

function initPageNbr(nbPerPages) {
    $('.observeToValidate').each(function () {
        if ($(this).data('obscount') > nbPerPages) {
            $(this).hide();
        }
    });
}

function updateObs(pageNbr) {
    let maxObs = 5*pageNbr;
    let minObs = maxObs-4;

    $('.observeToValidate').each(function () {
        $(this).show();
        if ($(this).data('obscount') < minObs || $(this).data('obscount') > maxObs) {
            $(this).hide();
        }
    });
}

function updatePrev(pageNbr) {
    if (pageNbr > 1) {
        $('#toValidatePagStart').removeClass('disabled').addClass('waves-effect');
    } else {
        $('#toValidatePagStart').addClass('disabled').removeClass('waves-effect');
    }
}

function updateNext(newPage, toValidatePages) {
    if (parseInt(newPage) === parseInt(toValidatePages)) {
        $('#toValidatePagEnd').addClass('disabled').removeClass('waves-effect');
    } else {
        $('#toValidatePagEnd').removeClass('disabled').addClass('waves-effect');
    }
}
