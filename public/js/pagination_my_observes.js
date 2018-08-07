$(document).ready(function() {

    // Pagination construction
    let myObservesLength = parseInt($('#myObservesObs').data('length'));
    let nbPerPages = 5;
    let myObservePages = constructMyObsPag(myObservesLength, nbPerPages);

    // Init pagination obsreves
    initMyObsPageNbr(nbPerPages);

    // Pagination numbers click behavior
    $('.myObservesPag').click(function (e) {
        e.preventDefault();
        let nbClicked = $(this).find('a').html();

        // Update active state
        $('.myObservesPag').each(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });

        // Set clicked to active
        $(this).addClass('active');
        updateMyObs(parseInt($(this).find('a').html()));

        // Update previous button
        updateMyObsPrev(nbClicked);

        // Update next button
        updateMyObsNext(nbClicked, myObservePages);
    });

    // Pagination previous behavior
    $('#myObservesPagStart').click(function () {
        let currentPage = $('.myObservesPag.active a').html();
        let newPage = parseInt(currentPage)-1;
        if (newPage < 1) {
            newPage = 1;
        }

        if (newPage) {
            // Update previous button
            updateMyObsPrev(newPage);

            // Update next button
            updateMyObsNext(newPage, myObservePages);

            // Move numbers
            $('.myObservesPag').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
                if (parseInt($(this).find('a').html()) === newPage) {
                    $(this).addClass('active');
                    updateMyObs(parseInt($(this).find('a').html()));
                }
            });
        }

    });

    // Pagination next behavior
    $('#myObservesPagEnd').click(function () {
        let currentPage = $('.myObservesPag.active a').html();
        let newPage = parseInt(currentPage)+1;
        if (newPage > parseInt(myObservePages)) {
            newPage = parseInt(myObservePages);
        }

        if (newPage) {
            // Update previous button
            updateMyObsPrev(newPage);

            // Update next button
            updateMyObsNext(newPage, myObservePages);

            // Move numbers
            $('.myObservesPag').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
                if (parseInt($(this).find('a').html()) === newPage) {
                    $(this).addClass('active');
                    updateMyObs(parseInt($(this).find('a').html()));
                }
            });
        }

    })
});

function constructMyObsPag(myObservesLength, nbPerPages) {
    let myObservePages;
    if (myObservesLength %5 !== 0) {
        myObservePages = Math.trunc(myObservesLength / nbPerPages)+1;
    } else {
        myObservePages = myObservesLength / nbPerPages;
    }
    for (let i = 1; i < myObservePages; i++) {
        $("#myObservesPagEnd").before('<li class="myObservesPag waves-effect"><a href="#!">' + parseInt(i + 1) + '</a></li>');
    }
    if (myObservePages === 1) {
        $('#myObservesPagEnd').addClass('disabled').removeClass('waves-effect');
    }
    return myObservePages;
}

function initMyObsPageNbr(nbPerPages) {
    $('.myObserve').each(function () {
        if ($(this).data('obscount') > nbPerPages) {
            $(this).hide();
        }
    });
}

function updateMyObs(pageNbr) {
    let maxObs = 5*pageNbr;
    let minObs = maxObs-4;

    $('.myObserve').each(function () {
        $(this).show();
        if ($(this).data('obscount') < minObs || $(this).data('obscount') > maxObs) {
            $(this).hide();
        }
    });
}

function updateMyObsPrev(pageNbr) {
    if (pageNbr > 1) {
        $('#myObservesPagStart').removeClass('disabled').addClass('waves-effect');
    } else {
        $('#myObservesPagStart').addClass('disabled').removeClass('waves-effect');
    }
}

function updateMyObsNext(newPage, myObservesPages) {
    if (parseInt(newPage) === parseInt(myObservesPages)) {
        $('#myObservesPagEnd').addClass('disabled').removeClass('waves-effect');
    } else {
        $('#myObservesPagEnd').removeClass('disabled').addClass('waves-effect');
    }
}
