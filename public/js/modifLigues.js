$(document).ready(function () {
    $(document).on('click', '.closeMdl, .btnCancelMdl', function () {
        $('#nomUser').hide();
        $('#nomMdl').hide();
    });

    //Obliger de passer par .on car après le load du tableau l'event click ne trigger plus.
    /*Informatisee Salle*/
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

    /*Changer Nom Salle*/
    $(document).on('click', '.btnNomLigue', function () {
        if (userLigue_id == 0) {
            $('#nomMdl').show();
            $('#nomLigue').val($(this).text());
        }
    });

    $(document).on('click', '#btnNomMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nomLigue",
                type: "POST",
                data: {
                    idLigue: $('.btnNomLigue').attr('id'),
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
    $(document).on('click', '.btnUserLigue', function () {
        if (userLigue_id == 0) {
            $('#nomUser').show();
            $('#nomUserLigue').val($(this).text());
        }
    });

    $(document).on('click', '#btnNomUserMdl', function () {
        if (userLigue_id == 0) {
            $.ajax({
                url: "index.php?action=UPD_nomUserLigue",
                type: "POST",
                data: {
                    idLigue: $('.btnNomLigue').attr('id'),
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