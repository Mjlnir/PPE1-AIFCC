$(document).ready(function () {
    $(document).on('click', '.closeMdl, .btnCancelMdl', function () {
        $('#nbSalleMaxMdl').hide();
        $('#modifSalleMdl').hide();
        $('#nomMdl').hide();
    });

    //Obliger de passer par .on car après le load du tableau l'event click ne trigger plus.
    /*Activer/Desactiver Salle*/
    $(document).on('click', '.btnActiveSalle', function () {
        $.ajax({
            url: "index.php?action=UPD_activeSalle",
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
            url: "index.php?action=UPD_informatiseeSalle",
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
        $('#nbSalleMaxMdl').show();
        $('#nbPlace').val($(this).text());
    });

    $(document).on('click', '#btnNbPlaceMaxMdl', function () {
        //        alert($('.btnNbPlaceSalle').attr('id') + ' ' + $('#nbPlace').val());
        $.ajax({
            url: "index.php?action=UPD_nbPlaceMaxSalle",
            type: "POST",
            data: {
                idSalle: $('.btnNbPlaceSalle').attr('id'),
                nbPlaceMax: $('#nbPlace').val()
            },
            dataType: "html"
        }).done(function (data) {
            console.log(data);
            $('#nbSalleMaxMdl').hide();
            $('#tbSalle').load('index.php?action=getSalle');
        });
    });
    
    /*Changer Nom Salle*/
    $(document).on('click', '.btnNomSalle', function () {
        $('#nomMdl').show();
        $('#nomSalle').val($(this).text());
    });

    $(document).on('click', '#btnNomMdl', function () {
        //        alert($('.btnNbPlaceSalle').attr('id') + ' ' + $('#nbPlace').val());
        $.ajax({
            url: "index.php?action=UPD_nomSalle",
            type: "POST",
            data: {
                idSalle: $('.btnNbPlaceSalle').attr('id'),
                nomSalle: $('#nomSalle').val()
            },
            dataType: "html"
        }).done(function (data) {
            console.log(data);
            $('#nomMdl').hide();
            $('#tbSalle').load('index.php?action=getSalle');
        });
    });
});
