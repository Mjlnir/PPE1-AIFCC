$(document).ready(function () {
    var iIdSalle;
    $(document).on('click', '.closeMdl, .btnCancelMdl', function () {
        $('#nbSalleMaxMdl').hide();
        $('#nomMdl').hide();
    });

    //Obliger de passer par .on car après le load du tableau l'event click ne trigger plus.
    /*Activer/Desactiver Salle*/
    $(document).on('click', '.btnActiveSalle', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_activeSalle",
                type: "POST",
                data: {
                    idSalle: $(this).attr('id')
                },
                dataType: "html"
            }).done(function (data) {
                $('#tbSalle').load('index.php?action=getSalles');
            });
        }
    });
    /*Informatisee Salle*/
    $(document).on('click', '.btnTypeSalle', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_informatiseeSalle",
                type: "POST",
                data: {
                    idSalle: $(this).attr('id')
                },
                dataType: "html"
            }).done(function (data) {
                $('#tbSalle').load('index.php?action=getSalles');
            });
        }
    });
    /*Changer Nb place Salle*/
    $(document).on('click', '.btnNbPlaceSalle', function (event) {
        if (userLigue_id == 0) {
            $('#nbSalleMaxMdl').show();
            $('#nbPlace').val($(this).text());
            iIdSalle = event.target.id; //Passation de l'id car récupération infructueuse lors de la requête ajax
        }
    });

    $(document).on('click', '#btnNbPlaceMaxMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nbPlaceMaxSalle",
                type: "POST",
                data: {
                    idSalle: iIdSalle,
                    nbPlaceMax: $('#nbPlace').val()
                },
                dataType: "html"
            }).done(function (data) {
                console.log(data);
                $('#nbSalleMaxMdl').hide();
                $('#tbSalle').load('index.php?action=getSalles');
            });
        }
    });

    /*Changer Nom Salle*/
    $(document).on('click', '.btnNomSalle', function (event) {
        if (userLigue_id == 0) {
            $('#nomMdl').show();
            $('#nomSalle').val($(this).text());
            iIdSalle = event.target.id; //Passation de l'id car récupération infructueuse lors de la requête ajax
        }
    });

    $(document).on('click', '#btnNomMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nomSalle",
                type: "POST",
                data: {
                    idSalle: iIdSalle,
                    nomSalle: $('#nomSalle').val()
                },
                dataType: "html"
            }).done(function (data) {
                $('#nomMdl').hide();
                $('#tbSalle').load('index.php?action=getSalles');
            });
        }
    });
});
