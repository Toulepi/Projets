$(document).ready(function (){
    // Chargement des données via appel de la fonction chargeDatas ()
    chargeDatas();

    // Desactivation de l'envoi inutile des données non modifiées
    $("#game-form").on('submit', function (event) {
       event.preventDefault();
    });

    // Insertion en BDD et mise à jour du tableau
    $("#submit_ajouter").on('click', function () {
        insert();
        chargeDatas();
    });

    // Faire disparaître le message de succès ou d'erreur
    $("#msg").dblclick(function(){
        $(this).fadeOut(1000);
    });

})

function insert() {

    let product ;
    let reponse = $("#reponse").val();
   // alert(reponse);
    let correct
    let idUser

    $.ajax({
        method: "POST",
        url: "server.php",
        data: {insert: 1, product: product, reponse: reponse, correct: correct,idUser:idUser}
    }).then(function (reponse) {
        //alert(reponse);

        //En cas de succès, on vide le champ input
        $("#reponse").val(null);

        // on recharge les fonctions rand () afin de regénerer de nouveaux nombres
        // think about doing it with Ajax

    })
}

function chargeDatas() {
    $.ajax({
        method: "GET",
        url: "server.php",
        data: {all: 1},
        dataType: 'json',  // 'json' est sous la forme {cle1: val1, cle2: val2, cle3: val3,...}
    }).done(function (response) {
       // alert(response);

        //On vide le contenu du tableau
        $("#score-body").empty();
        response.forEach(ligne => {
            $("#score-body").append(
                `<tr>`
                + `<td>${ligne.idUser}</td>`
                + `<td class="product">${ligne.product}</td>`
                + `<td class="reponse">${ligne.reponse}</td>`
                + `<td class="correct">${ligne.correct}</td>`
                + `</tr>`
            );
        });
    });
}