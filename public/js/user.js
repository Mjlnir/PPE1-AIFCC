$(document).ready(function () {
    var idUser;
    var idLigue;

    $(document).on('click', '.closeMdl, .btnCancelMdl', function () {
        $('#nbSalleMaxMdl').hide();
        $('#nomMdl').hide();
    });

    $(document).on('click', '.btnNomUtilisateur', function () {
        $.ajax({
            url: "index.php?action=UPD_nomUser",
            type: "POST",
            data: {
                idSalle: $(this).attr('id')
            },
            dataType: "html"
        }).done(function (data) {
            alert(data);
//            $('#tbSalle').load('index.php?action=getSalles');
        });
    });
});
