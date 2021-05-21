<?php
$sess_payement_add = $this->session->userdata['payement_add'];
$sess_payement_del = $this->session->userdata['payement_del'];
$sess_payement_index = $this->session->userdata['payement_index'];
?>
<style>
#payment_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#payment_all {
    table-layout: fixed;
}

#payment_all tbody tr:hover {
    background: aliceblue;
}
</style>
<div id="headerbar">
    <?php
$min_y = "2019";
$max = date("Y");
$mois_array = array(
    "1" => "Janvier",
    "2" => "Février",
    "3" => "Mars",
    "4" => "Avril",
    "5" => "Mai",
    "6" => "Juin",
    "7" => "Juillet",
    "8" => "Août",
    "9" => "Septembre",
    "10" => "Octobre",
    "11" => "Novembre",
    "12" => "Décembre",
);
?>
    <table class="tab-depense" style=" width:100%; margin-top: 0px;">
        <tr>
            <td class="form-widh commande depense" style=" width:20%">
                 <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0; margin-right: 15px;">
                     <div class="form-group">
						<input id="filter_payment" type="text" class="search-query form-control input-sm" placeholder="<?php echo $filter_placeholder; ?>">
                     </div>
                 </form>
            </td>
            <td style="width:13%">
                <select class="form-control select_filter" id="select_payment_method">
                    <option value="all"><?php echo lang('moyenpaiment'); ?></option>
                    <?php foreach ($payment_methods as $payment_method) {?>
                    <option value="<?php echo $payment_method->payment_method_id; ?>">
                        <?php echo $payment_method->payment_method_name; ?></option>

                    <?php }?>
                </select>

            </td>
            <td style="width:12%">
                <select class="form-control select_filter" id="select_filter_year">
                    <option value="all"><?php echo lang('year'); ?></option>
                    <?php for ($i = $max; $i >= $min_y; $i--) {?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php }
?>
                </select>
            </td>
            <td style="width:12%">
                <select class="form-control select_filter" disabled="disabled" id="select_filter_month">
                    <option value="all"><?php echo lang('month'); ?></option>
                    <?php foreach ($mois_array as $key => $val) {?>
                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                    <?php }
?>
                </select>
            </td>
			<td align="right" class="pull-block" style=" width:42%">
                 <div class="pull-right">
                     <?php if (rightsExportExcel()) {?>
                     <button id="export_excel"
                         class="btn btn-sm btn export-excel">
                        <i class="fas fa-file"></i><?php echo lang('exporter'); ?>
                     </button>
                     <?php }?>
                     <a class="agenda-depense btn btn-md-size btn-light-primary"
                         href="<?php echo site_url('depenses/agenda'); ?>">
                         <?php echo lang('agenda'); ?>
                     </a>
                     <a class="create-depense btn btn-sm no-marg btn-primary btn-light-success"
                         href="<?php echo site_url('depenses/form'); ?>">
                         <?php echo lang('create_expense'); ?>
                     </a>
                 </div>
             </td>
        </tr>
    </table>
    <div style="clear:both"></div>
</div>
 <div class="row">
     <div class="col-md-12">
         <div class="portlet light">
             <div id="content" class="table-content">
                <?php // $this->layout->load_view('layout/alerts');  ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="payment_all">
                        <thead>
                            <tr>
                                <th width="auto" order="ip_depense.date_facture"><?php echo lang('invoice_date'); ?></th>
                                <th width="auto" order="ip_depense.date_paiement"><?php echo lang('payment_date'); ?></th>
                                <th width="auto" order="ip_depense.num_facture"><?php echo lang('num_facture'); ?></th>
                                <th width="auto" order="ip_depense.id_fournisseur"><?php echo lang('Fournisseurs'); ?></th>
                                <th width="auto" order="ip_depense.montant_facture"><?php echo lang('montant_ht'); ?></th>
                                <th width="auto" order="ip_depense.montant_tva"><?php echo lang('montant_tva'); ?></th>
                                <th width="auto" order="ip_depense.net_payer"><?php echo lang('total_a_payer_pdf'); ?></th>
                                <th width="auto" order="ip_payment_methods.payment_method_name"><?php echo lang('payment_method'); ?></th>
                                <th style="white-space:nowrap; width: 50px;"><?php //echo lang('options');   ?></th>
                            </tr>
                        </thead>
                        <tbody id="filter_results">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	
	
	<!-- pagination -->
<div class="pag-table-content">
    <div class="pull-right visible-lg">
        <select class="btn btn-default btn-sm bg-light-primary pagin" id="payments_par_page">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="200">200</option>
        </select>
    </div>
    <div class="pull-right visible-lg" style="margin:0 7px;">
        <div class="btn-group">
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_backward" href="javascript:;"><i class="fas fa-angle-double-left"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_backward" href="javascript:;"><i class="fas fa-angle-left"></i></a>
            <span class="btn btn-sm btn-default btn-hover-primary pagin active" style="background:none;" id="number_current_page">1/1</span>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fa_forward" href="javascript:;"><i class="fas fa-angle-right"></i></a>
            <a class="btn btn-default btn-sm disabled paginate btn-light-primary" id="btn_fast_forward" href="javascript:;"><i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>
	<!-- end pagination -->
</div>
<script type="text/javascript">
$(function() {

    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_depense.date_facture";
    order_method = "desc";
    if (typeof(page) == 'undefined') {
        page = 1;
    }
    if (typeof(filter_year) == 'undefined') {
        filter_year = "all";
    }
    if (typeof(filter_month) == 'undefined') {
        filter_month = "all";
    }
    if (typeof(filter_payment_method) == 'undefined') {
        filter_payment_method = "all";
    }
    if (typeof(filter_payment_input) == 'undefined') {
        filter_payment_input = "";
    }



    $('#filter_payment').keyup(function() {
        filter_payment_input = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterPayments();

    });
    $('#select_filter_year').change(function() {
        filter_year = $(this).val();
        start_page = 1;
        nb_pages = 1;
        if (filter_year == "all") {
            $('#select_filter_month').val("all");
            filter_month = "all";
            $('#select_filter_month').attr("disabled", true);
        } else {
            $('#select_filter_month').attr("disabled", false);
        }
        filterPayments();
    });

    $('#select_filter_month').change(function() {
        filter_month = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterPayments();
    });

    $('#select_payment_method').change(function() {
        filter_payment_method = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterPayments();
    });


    $(".paginate").click(function() {
        var btn = $(this).attr("id");
        if (btn == "btn_fast_backward") {
            start_page = 1;
        }
        if (btn == "btn_fa_backward") {
            start_page = start_page == 1 ? 1 : start_page - 1;
        }
        if (btn == "btn_fast_forward") {
            start_page = nb_pages;
        }
        if (btn == "btn_fa_forward") {
            start_page = start_page == nb_pages ? nb_pages : start_page + 1;
        }
        filterPayments();
    });
    $("#payments_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterPayments();
    });

    $("#payment_all thead tr th").click(function() {
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
            filterPayments();
        }
    });

    filterPayments();

    function filterPayments() {

        $('#filter_results').load("<?php echo site_url('depenses/ajax/load_depenses_partial_filter'); ?>/" +
            Math.floor(Math.random() * 1000), {
                filter_payment_input: filter_payment_input,
                filter_year: filter_year,
                filter_month: filter_month,
                filter_payment_method: filter_payment_method,
                limit_par_page: limit_par_page,
                start_page: start_page,
                order_by: order_by,
                order_method: order_method
            },
            function(data) {}, 500);
    }
});
</script>