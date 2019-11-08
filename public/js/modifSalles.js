$(document).ready(function () {
    var idSalle;

    $('.closeMdl, #btnCancelMdl').click(function () {
        $('#nbSalleMdl').hide();
        $('#modifSalleMdl').hide();
    });

    //Obliger de passer par .on car après le load du tableau l'event click ne trigger plus.
    /*Activer/Desactiver Salle*/
    $(document).on('click', '.btnActiveSalle', function () {
        $.ajax({
            url: "index.php?action=activeSalle",
            type: "POST",
            data: {
                idSalle: $(this).attr('id')
            },
            dataType: "html"
        }).done(function (data) {
            $('#tbSalle').load('index.php?action=getSalle');
        });
    });
    /*Informatisee Salle*/
    $(document).on('click', '.btnTypeSalle', function () {
        $.ajax({
            url: "index.php?action=InformatiseeSalle",
            type: "POST",
            data: {
                idSalle: $(this).attr('id')
            },
            dataType: "html"
        }).done(function (data) {
            $('#tbSalle').load('index.php?action=getSalle');
        });
    });
    /*Changer Nb place Salle*/
    $(document).on('click', '.btnNbPlaceSalle', function () {
        $('#nbSalleMdl').show();
        $('#nbPlace').val($(this).find('a').text());
    });
});
