<script src="./assets/js/jquery-3.3.1.js"></script>
<script src="./assets/js/jquery.dataTables.min.js"></script>
<script src="./assets/js/dataTables.bootstrap.min.js"></script>



<div>
    <!--<input id="vlpage" value='1' hidden>
    <table style="margin-left: 86%;">
        <th>
            <div class="pull-right visible-lg">
                <div class="btn-group">
                    <a class="btn btn-default btn-sm  paginate" id="btn_fast_backward" href="javascript:;"><i
                            class="fa fa-fast-backward no-margin"></i></a>
                    <a class="btn btn-default btn-sm  paginate" id="btn_fa_backward" onclick=reload()
                        href="javascript:;"><i class="fa fa-backward no-margin"></i></a>
                    <span class="btn btn-sm btn-default " style="background:none;" id="number_current_page">1/1</span>
                    <a class="btn btn-default btn-sm  paginate" id="btn_fa_forward" href="javascript:;"><i
                            class="fa fa-forward no-margin"></i></a>
                    <a class="btn btn-default btn-sm  paginate" id="btn_fast_forward" href="javascript:;"><i
                            class="fa fa-fast-forward no-margin"></i></a>
                </div>
            </div>
        </th>
    </table>-->
	 <div class="portlet-body table-responsive">
    <table id="tracktable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>
				<?php echo lang('from'); ?>
                </th>
                <th>
				<?php echo lang('to'); ?>
                </th>
                <th>
				<?php echo lang('date-envoi'); ?>
                </th>
                <th>
                   <?php echo lang('objet_mail'); ?>
                </th>
                <th>
                 <?php echo lang('status'); ?>
                </th>
            </tr>
        <tbody>
		</div>
            <?php
//var_dump($tracking);

for ($i = 0; $i < count($tracking); $i++) {?>
            <tr>
                <td>

                </td>
                <td>
                </td>
                <td>
                    <?php echo ($tracking[$i]->log_date) ?>
                </td>
                <td>
                    <?php echo ($tracking[$i]->log_id) ?>
                </td>
                <td>
                    <?php $tracking[$i]->vu == '1' ? print 'Vu' : print 'Non vu';?>
                </td>
            </tr>
            <?php }?>
        </tbody>

    </table>
</div>
<script>
function reload(num) {
    $.ajax({
        url: "/settings/trackingajax",
        method: "post",
        data: {
            'num': num
        },
        success: function(data) {
            // alert(data);
            $('#vlpage').val();
            $('#tbi').html(data);
        }
    });
}
//reload(1);
</script>
<script>
$('#tracktable').DataTable({
    "oLanguage": {
        "sProcessing": "Traitement en cours...",
        "sSearch": "Rechercher&nbsp;:",
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
    }
})
</script>