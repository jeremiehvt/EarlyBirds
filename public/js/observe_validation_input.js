$(function() {
    let photo = $('input[type="file"]');
    photo.on('change', function (e) {
        if (e.target.files.length === 1) {
            let nameId = $('#' + e.target.parentElement.id);
            nameId.toggleClass('green');
            let spn = $('#' + e.target.parentElement.id +'> span');
            spn.text("photo téléchargée").css('text-transform','Capitalize');
            M.toast({html: 'téléchargement de fichier réussi'});
        }
    });
});