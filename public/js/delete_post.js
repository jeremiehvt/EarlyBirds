$(document).ready(function ($) {
    $(document).on('click', '.data-delete-post', function (event) {
        console.log(event);
         event.preventDefault();
         $.ajax({
         method: "DELETE",
         url: $(this).attr('data-delete'),
         timeout: 3000,
         success: function (data) {
             M.toast({html: data});
                 setTimeout(function () {
                     document.location.reload();
                 }, 2500);
             }
         });
         return false;
    });
});
