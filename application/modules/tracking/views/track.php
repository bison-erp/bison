<script src="../assets/js/jquery-3.3.1.js"></script>
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dataTables.bootstrap.min.js"></script>


<div id="headerbar">
<div class="pull-left" style="margin: 15px 0;">
    <select class="form-control select_filter" id="stat">
        <option value="0">Tout</option>
        <option value="1">Lu</option>
        <option value="2">Non lu</option>
    </select>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light table-responsive">
            <table id="tbl" class="table table-striped ">
                <thead>
                    <tr>

                        <th>From</th>
                        <th>To</th>
                        <th>Date d'envoi</th>
                        <th>Objet mail</th>
                        <th style=" width: 10%;">État</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>



<script>
function createdate() {
    $('#tbl').dataTable({
        "pageLength": 50,
        "oLanguage": {
            "sProcessing": "Traitement en cours...",
            "sSearch": "Filtrer&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix": "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            },
            "select": {
                "rows": {
                    _: "%d lignes séléctionnées",
                    0: "Aucune ligne séléctionnée",
                    1: "1 ligne séléctionnée"
                }
            }
        },
        "processing": true,
        ajax: {
            url: '/tracking/extrack',
            dataSrc: 'data',
            type: 'GET',
            data: {
                typelu: $("#stat").val(), // Second add quotes on the value.
            },
        },
        columns: [{
                data: "from"
            },
            {
                data: "to"
            }, {
                data: "date"
            }, {
                data: "object"
            }, {
                data: "etat"
            }

        ]
    });
}
createdate();

var mrg = 55;
$('.dataTables_filter').css('margin-left', mrg + '%');

$("#stat").change(function() {
    console.log('1');
});
</script>