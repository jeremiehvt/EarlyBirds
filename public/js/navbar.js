$(function() {
    $(".dropdown-trigger").dropdown(
        { hover: true }
    );
    $(".dropdown-trigger").hover( function () {
        $('.dropdown-content').css('position','absolute').css('top','60px');
    });
    $('.sidenav').sidenav();
    $('#mobile-demo').collapsible();
});