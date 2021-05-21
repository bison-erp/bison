<?php
//rebrique fournisseur: selon les droit données
$sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
$sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
$sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
?>
<style>
#fournisseur_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#fournisseur_all {
    table-layout: fixed;
}

#fournisseur_all tbody tr:hover {
    background: aliceblue;
}
select#select_filter_categorie {
    width: 200px;
    margin-left: 15px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    vertical-align: middle;
    padding: 12px 8px;
}
</style>
<div id="headerbar">

     <table style="width:100%; margin-top: 0px;">
         <tr>
             <td align="right" class="form-widh" style="width:25%">
				 <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                     <div class="form-group">
							<input id="filter_fournisseur_input" type="text"  class="search-query form-control input-sm" placeholder="<?php echo lang('filter_suppliers'); ?>">
                     </div>
                 </form>
            </td>
			<td align="center" style=" width:15%">
                <select class="form-control select_filter" id="select_filter_categorie">
                    <option value="-1"><?php echo lang('supplier_group'); ?></option>
                    <?php foreach ($mdl_categorie_fournisseur as $fournisseur) {?>
                    <option value="<?php echo $fournisseur->id_categorie_fournisseur; ?>">
                        <?php echo $fournisseur->designation; ?></option>
                    <?php }?>
                </select>
            </td>

            <?php if ($sess_fournisseur_add == 1) {?>

             <td align="right" class="pull-block" style=" width:70%">
                <div class="pull-right">	
					<a class="btn btn-md-size create-groupe btn-primary btn-success" href="<?php echo site_url('categorie_fournisseur/form'); ?>">
						<?php echo lang('create_groupe'); ?>
					</a>
                    <a class="btn btn-sm btn-primary no-marg  btn-light-success" href="<?php echo site_url('fournisseurs/form'); ?>">
                        <?php echo lang('create_fournisseur'); ?></a>
                </div>
            </td>
            <?php }?>

        </tr>
    </table>

</div>



<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts');?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
            <div id="content" class="table-content">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="fournisseur_all">
                        <thead>
                            <tr>
                                <th style=" white-space:nowrap; width: 300px;" order="ip_fournisseurs.raison_social_fournisseur">
                                    <?php echo lang('raison_social_fournisseur'); ?></th>
                                <th style="white-space:nowrap; width: 250px;" order="ip_fournisseurs.adresse_fournisseur">
                                    <?php echo lang('adresse_fournisseur'); ?></th>

                                <th style="white-space:nowrap; width: 250px;text-align: center;" order="ip_fournisseurs.mail_fournisseur">
                                    <?php echo lang('mail_fournisseur'); ?>
                                </th>
                                <th style="white-space:nowrap; width: 238px;text-align: center;" order="ip_fournisseurs.tel_fournisseur">
                                    <?php echo lang('tel_fournisseur'); ?></th>
                                <th width="40"></th>
                                 <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody id="filter_results">
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" style="background:#FFF;" id="fournisseur_par_page">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="200">200</option>
        </select>
    </div>
	<div class="pull-right" style="margin:0 7px;">
        <div class="btn-group">
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_backward" href="javascript:;"><i class="fas fa-angle-double-left"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_backward" href="javascript:;"><i class="fas fa-angle-left"></i></a>
            <span class="btn btn-sm btn-default btn-hover-primary pagin active" style="background:none;" id="number_current_page">1/1</span>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_forward" href="javascript:;"><i class="fas fa-angle-right"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_forward" href="javascript:;"><i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>
<script>
function filterFournisseur() {
    $('#filter_results').load(
        "<?php echo site_url('fournisseurs/ajax/load_fournissuer_partial_filter'); ?>/" +
        Math.floor(Math.random() * 1000), {
            filter_fournisseur: filter_fournisseurs,
            filter_categorie: filter_categorie,
            limit_par_page: limit_par_page,
            start_page: start_page,
            order_by: order_by,
            order_method: order_method
        },
        function(data) {}, 500);
}
$(function() {
    if (typeof(filter_fournisseurs) == 'undefined') {
        filter_fournisseurs = "";
    }
    if (typeof(filter_categorie) == 'undefined') {
        filter_categorie = "";
    }
    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_fournisseurs.id_fournisseur";
    order_method = "desc";

    $("#fournisseur_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterFournisseur();
    });

    $('#filter_fournisseur_input').keyup(function() {
        filter_fournisseurs = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterFournisseur();

    });
    $('#select_filter_categorie').change(function() {
        filter_categorie = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterFournisseur();

    });
    $(".paginate").click(function() {
        var btn = $(this).attr("id");
        if (btn == "btn_fast_backward") {
            start_page = 1;
        }
        if (btn == "btn_fa_backward") {
            start_page = start_page == 1 ? 1 : parseInt(start_page) - 1;
        }
        if (btn == "btn_fast_forward") {
            start_page = nb_pages;
        }
        if (btn == "btn_fa_forward") {
            start_page = start_page == nb_pages ? nb_pages : parseInt(start_page) + 1;
        }
        filterFournisseur();
    });
    $("#fournisseur_all thead tr th").click(function() {

        var order = $(this).attr("order");
        if (order) {
            if (order_by != order) {
                order_by = order;
                order_method = "asc";
            } else {
                if (order_method == "asc") {
                    order_method = "desc";
                } else
                if (order_method == "desc") {
                    order_method = "asc";
                }
            }
            start_page = 1;
            filterFournisseur();
        }
    });
    filterFournisseur();
})
</script>