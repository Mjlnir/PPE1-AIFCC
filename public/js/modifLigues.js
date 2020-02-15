$(document).ready(function () {
    var idLigue;

    $(document).on('click', '.closeMdl, .btnCancelMdl', function () {
        $('#nomUser').hide();
        $('#nomMdl').hide();
    });

    //Obliger de passer par .on car après le load du tableau l'event click ne trigger plus.
    /*Active Ligue*/
    $(document).on('click', '.btnActiveLigue', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_activeLigue",
                type: "POST",
                data: {
                    idLigue: $(this).attr('id')
                },
                dataType: "html"
            }).done(function (data) {
                $('#tbLigue').load('index.php?action=getLigues');
            });
        }
    });

    /*Changer Nom Ligue*/
    $(document).on('click', '.btnNomLigue', function (event) {
        if (userLigue_id == 0) {
            $('#nomMdl').show();
            $('#nomLigue').val($(this).text());
            idLigue = event.target.id;
        }
    });

    $(document).on('click', '#btnNomMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nomLigue",
                type: "POST",
                data: {
                    idLigue: idLigue,
                    nomLigue: $('#nomLigue').val()
                },
                dataType: "html"
            }).done(function (data) {
                $('#nomMdl').hide();
                $('#tbLigue').load('index.php?action=getLigues');
            });
        }
    });

    /*Changer Utilisateur*/
    $(document).on('click', '.btnUserLigue', function (event) {
        if (userLigue_id == 0) {
            $('#nomUser').show();
            $('#nomUserLigue').val($(this).text());
            idLigue = event.target.id;
        }
    });

    $(document).on('click', '#btnNomUserMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nomUserLigue",
                type: "POST",
                data: {
                    idLigue: idLigue,
                    idUserLigue: $('#nomUserLigue :selected').attr('id')
                },
                dataType: "html"
            }).done(function (data) {
                $('#nomUser').hide();
                $('#tbLigue').load('index.php?action=getSalle');
            });
        }
    });
});
