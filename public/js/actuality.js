$(function () {

    let searchBar = $('input#search');
    let contentDiv = $('#article');
    let role = $('#author').attr('data-author');

   function construct(datas) {
       let nickname;

       if (datas.author.nickname === null) {
           nickname = "NC";
       } else {
           nickname = datas.author.nickname;
       }

       let favorite = datas.favouredBy;
       let favored;

       if (favorite.length > 0)
       {
           favorite.forEach(function () {
               favored ++;
           });
       } else { favored = ""}

       let content;

       let authorRole;

       let auth = datas.author.roles;

       if (jQuery.inArray("ROLE_ADMIN",auth)) {
           authorRole = "administrateur";
       } else if (jQuery.inArray("ROLE_NATURALIST",auth) ) {
           authorRole = "naturaliste";
       } else {
           authorRole = "";
       }

       if (role === "ROLE_ADMIN" || role === "ROLE_NATURALIST") {
           content =
               "<a class ='data-delete-post' href='' data-delete ='/delete-article-"+datas.id+"'>" +
               "<i class ='material-icons head-delete'>delete</i>"+
               "</a>"+ "<a href ='"+document.location.origin+"/modifier-article-"+datas.id+"'>" +
               "<i class ='material-icons head-edit'>edit</i>"+
               "</a>";
       } else {
           content = "";
       }

       let dateArticle = new Date(datas.createdAt.date);

       let YY = dateArticle.getFullYear();
       let DD = dateArticle.getDate();
       let MM;

       switch(dateArticle.getMonth()){
           case 1: MM = "Janvier";
               break;
           case 2: MM = "Février";
               break;
           case 3: MM = "Mars";
               break;
           case 4: MM = "Avril";
               break;
           case 5: MM = "Mai";
               break;
           case 6: MM = "Juin";
               break;
           case 7: MM = "Juillet";
               break;
           case 8: MM = "Août";
               break;
           case 9: MM = "Septembre";
               break;
           case 10: MM = "Octobre";
               break;
           case 11: MM = "Novembre";
               break;
           case 12: MM = "Décembre";
               break;
       }


       contentDiv.append(
           "<div class='col l6 m6 s12'>" +
                "<div class='card' id='article-card'>" +
                    "<div class='card-image'>" +
                        "<img src='"+ datas.img +"'/>"+
                        "<h2 class='card-title' id='article-card-title'>"+ datas.title +"</h2>"+
                    "</div>" +
                    "<div class='card-content'>" +
                        "<p>auteur : <em>"+ nickname +" - "+ authorRole +"</em></p>"+
                        "<p class='short'><strong class='short-head'>Description</strong><br>"+datas.shortDesc+"</p>"+
                        "<p class='chip'>"+ datas.category +" </p>"+
                        "<p>créé le : <em>"+DD+" "+MM+" "+YY+"</em></p>"+
                        "<a id='head-article-link' href='"+document.location.href+"/article-"+ datas.id +"'>lire l'article</a>"+
                    "</div>"+
                    "<div class='card-action'>" +
                            "<div class='head-link'>"+
                                "<a href=''>" + favored +
                                    "<i class='material-icons head-heart'>favorite_border</i>"+
                                "</a>"+
                               "<a href=''>" +
                               "<i class='material-icons head-share'>share</i>"+
                               "</a>"+ content +
                            "</div>"+
                    "</div>"
               + "</div>"
           + "</div>"
       );

   }

    $(searchBar).on('keyup', function (e) {

        if (e.target.value.length === 0) {
            $.getJSON(document.location.href + '/search-post',
                function (data) {
                    contentDiv.html("");
                    if (data.length === 0) {
                        contentDiv.html("<p>pas de resultat pour votre recherche</p>");
                    } else {
                        data.forEach(function (datas) {
                            construct(datas);
                        })
                    }
                }
            );
        } else {

            $.getJSON(document.location.href + '/search-post-'+e.target.value,
                function (data) {
                    contentDiv.html("");
                    if (data.length === 0) {
                        contentDiv.html("<p>pas de resultat pour votre recherche</p>");
                    } else {
                        data.forEach(function (datas) {
                            construct(datas);
                        })
                    }
                }
            );

        }
    });

   $('.category-link').on('click', function () {
       category = $(this).attr('data-cat');
       $.getJSON(document.location.href + '/search-post-category-'+category,
           function (data) {
               contentDiv.html("");
               if (data.length === 0) {
                   contentDiv.html("<p>pas de resultat pour votre recherche</p>");
               } else {
                   data.forEach(function (datas) {
                       construct(datas);
                   })
               }
           }
       );
   });

    $('.toggle-heart').on('click', function (e) {
        e.preventDefault();

        let $link = $(e.currentTarget);

        $link.find('.material-icons').hide();
        $link.find('#ajaxLoading').show();

        let id = $(this).find('#postheart').data('id');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {

            $link.find('.material-icons').show();
            $link.find('#ajaxLoading').hide();
            $('.head-link').each(function () {

                if ($(this).find('#postheart').data('id') === id) {
                    switch ($(this).find('.head-heart').html()) {
                        case "favorite_border":
                            $(this).find('.head-heart').html('favorite');
                            break;
                        case "favorite":
                            $(this).find('.head-heart').html('favorite_border');
                            break;
                    }
                    $(this).find('.js-like-post-count').html(data.hearts);
                }
            });
        });
    });

    let url = $('#heart-infos').data('url');
    $.getJSON(url, function (data) {
        $.each(data, function (key, val) {
            let id = val;
            $('.head-link').each(function () {
                let heart = $(this).find('#postheart');
                if (heart.data('id') === id) {
                    heart.html("favorite")
                }
            })
        })
    });

    $('#newsletter-form button').click(function (e) {
        e.preventDefault();
        let mail = $('.actalitynewsletter').val();
        let $helperText = $('#newsletter-form > span');

        $.ajax({
            method: 'POST',
            url: document.location.origin+"/newsletter/"+mail,
        }).done(function (data) {
            if (data === true) {
                $helperText.attr('data-error', "Vous êtes déjà enregistré à la newsletter");
                $('#email_inline.actalitynewsletter').removeClass('valid').addClass('invalid');
                $helperText.show().delay(5000).fadeOut('normal');
            } else {
                $helperText.attr('data-success', "Merci pour votre inscription à la newsletter");
                $helperText.show().delay(5000).fadeOut('normal');
            }
        });
    });
});