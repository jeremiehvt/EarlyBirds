 $(function () {
     let btnRole = $('#btn-role');
     let member = $('#member');

     btnRole.on('click', function () {
         console.log();
         if (member.css('display') === 'none') {
             member.show();
             btnRole.text("EN SAVOIR -");
         } else {
             member.hide();
             btnRole.text("EN SAVOIR +");
         }
     });

     let btnDonate = $('#btn-donate');
     let don = $('#hide-donate');

     btnDonate.on('click', function () {
         console.log();
         if (don.css('display') === 'none') {
             don.show();
             btnDonate.text("EN SAVOIR -");
         } else {
             don.hide();
             btnDonate.text("EN SAVOIR +");
         }
     });
 });