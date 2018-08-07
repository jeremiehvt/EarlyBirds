tinymce.init({
                 selector:'.tinymce',
                 plugins: ["lists advlist link"],
                 menubar: 'edit view insert',
                 language: 'fr_FR',
                 branding: false,
                 toolbar: 'undo redo | styleselect | alignleft aligncenter' +
                          ' alignright alignjustify | bullist numlist | link',

                 style_formats: [
                     {title: 'Header 2', block: 'h2', classes: 'content_h2'},
                     {title: 'Header 3', block: 'h3', classes: 'content_h3'},
                     {title: 'Header 4', block: 'h4', classes: 'content_h4'},
                     {title: 'Paragraph', block: 'p', classes: 'paraph'},
                     {title: 'Blockquote', block: 'blockquote', classes: 'quote'},
                     {title: 'address', format: 'address'},
                     {title: 'Bold', icon: 'bold', inline: 'strong', classes: 'b_text'},
                     {title: 'Italic', icon: 'italic', inline: 'em', classes: 'em_text'}
                 ],
                 protect: [
                     /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                     /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                     /<\?php.*?\?>/g,  // Protect php code
                 ],
                 advlist_bullet_styles: 'default circle square',
                 advlist_number_styles: 'default upper-roman upper-alpha lower-alpha',

             });

$(function () {
    //flash message after valide or update obs
   let msgUn = $('.flash-post');
    let url = document.location.origin +'/saisir-article#1';
    if (msgUn !== undefined) {

        if (msgUn.text().length > 0) {
            document.location.assign(url);
            msgUn.fadeOut(9000)
        }
    }

    let counter = $('.counter');

        counter.on('keyup', function () {

            let count = $('.counter').val();

            if ( count.length < 130 || count.length > 320) {

              counter.css('border', '3px solid red');
            } else if(count.length >= 130 || count.length <= 320) {

                counter.css('border' , '3px solid green');
            }
            $('.form_carac_number').text('Nombre de caractère de la description : ' + count.length + ' caractères');
        });

        counter.on('blur', function () {
           counter.css('border', 'none');
        });
});
