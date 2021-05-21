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
    font-size: 13px!important;
    font-weight: 600;
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
$min_y = "2014";
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

<table style=" width:100%; margin-top: 0;">
        <tr class="bloc-encaiss">
            <td align="right" class="form-widh encaiss" style=" width:30%">
                 <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                     <div class="form-group">
						<input id="filter_payment" type="text" class="search-query form-control input-sm" placeholder="<?php echo $filter_placeholder; ?>">
                     </div>
                 </form>
            </td>
			
           <td align="center" style=" width:15%">
                <select class="form-control select_filter" id="select_payment_method" style="width:200px;">
                    <option value="all"><?php echo lang('payment_method'); ?></option>
                    <?php foreach ($payment_methods as $payment_method) {?>
                    <option value="<?php echo $payment_method->payment_method_id; ?>">
                        <?php echo $payment_method->payment_method_name; ?></option>
                    <?php }?>
                </select>
            </td>

             <td align="center" style=" width:10%">
                <select class="form-control select_filter" id="select_filter_year">
                    <option value="all"><?php echo lang('year'); ?></option>
                    <?php for ($i = $max; $i >= $min_y; $i--) {?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </td>
			
             <td align="center" style=" width:10%">
                <select class="form-control select_filter" disabled="disabled" id="select_filter_month">
                    <option value="all"><?php echo lang('month'); ?></option>
                    <?php foreach ($mois_array as $key => $val) {?>
                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                    <?php }
?>
                </select>
            </td>
		
			 <td align="right" class="pull-block encaiss" style=" width:45%">
                <div class="pull-right">
                     <button type="button" style="height: 25px; padding: 3px 6px 8px 7px !important; display: none"
                         class="btn btn-default btn-sm submenu-toggle hidden-lg" data-toggle="collapse"
                         data-target="#ip-submenu-collapse">
                         <i class="fa fa-bars"></i> <?php echo lang('submenu'); ?>
                     </button>
					<button id="export_excel" class="btn btn-sm btn export-excel">  <i class="fas fa-file"></i><?php echo lang('exporter') ?> 
					</button>
                    <a class="btn btn-sm btn-primary  no-marg btn-light-success encaiss" href="<?php echo site_url('payments/form'); ?>">
                        <?php echo lang('create_payment'); ?>
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
                    <table class="table table-striped table-responsive" id="payment_all">
                        <thead>
                            <tr>

                                <th order="ip_payments.payment_date" style="white-space:nowrap;">
                                    <?php echo lang('payment_date'); ?></th>
                                <th order="ip_invoices.invoice_date_created" style="white-space:nowrap;">
                                    <?php echo lang('invoice_date'); ?></th>
                                <th order="ip_invoices.invoice_number" style="white-space:nowrap;">
                                    <?php echo lang('invoice'); ?></th>
                                <th order="client_societe2" style="white-space:nowrap;">
                                    <?php echo lang('client'); ?></th>
                                <th order="ip_payments.payment_amount" style="white-space:nowrap;">
                                    <?php echo lang('amount'); ?></th>
                                <th order="ip_payment_methods.payment_method_name"
                                    style="white-space:nowrap;"><?php echo lang('payment_method'); ?></th>
                                <th order="ip_payments.payment_ref" style="white-space:nowrap;">
                                    <?php echo lang('reference'); ?></th>
                                <th order="ip_payments.payment_note" style="white-space:nowrap;">
                                    <?php echo lang('note'); ?></th>
                                <th style="width: 50px;">
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="check_all" class="md-check">
                                            <label for="check_all">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                </th>
                                <th style="white-space:nowrap;width: 50px;" align="right">
                                     <div class="options btn-group">
                                         <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                             href="#">
                                             <i class="fa fa-cog"></i> <?php // echo lang('options');     ?>
                                         </a>
                                         <ul class="dropdown-menu" style="margin-left: -131px; margin-top: 2px;">
                                             <!--<li style="display:none" id="select_all">-->
                                             <li>
                                                 <a href="#">
                                                     <div id="select_all" class="md-checkbox">
                                                         <input type="checkbox" id="aa">
                                                         <label for="aa"><?php echo lang('select_all'); ?>
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                         </label>
                                                     </div>
                                                 </a>
                                                 <div class='selectinput'>

                                                 </div>
                                             </li>
                                         </ul>
                                     </div>
                                 </th>                                 
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

<!-- pagination -->
<div class="pag-table-content">
	<div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" style="background:#FFF;" id="payments_par_page">
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
<!-- end pagination -->

<script type="text/javascript">
$('#export_excel').prop('disabled', true);
$(function() {

    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_payments.payment_date";
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

        $('#filter_results').load("<?php echo site_url('payments/ajax/load_payments_partial_filter'); ?>/" +
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
function myFunctionchech(i){
    var ids_client = [];
    var ids_client_sep = "";
    var cnt = 0;
    $('input:checked[name="Choix[]"]').each(function() {
            if (cnt != 0) {
                ids_client_sep += "_";
            }
            ids_client_sep += $(this).val();
            ids_client.push(parseInt($(this).val()));
            cnt++;
           
        }); 
        if(ids_client.length>0){
                $('#export_excel').prop('disabled', false);
            }else{
                 $('#export_excel').prop('disabled', true);
            }      
}


$("#check_all").click(function() {
        if ($(this).is(':checked')) {
             $('#export_excel').prop("disabled", false);
            $("#filter_results tr td .md-check").each(function() {
                this.checked = true;
            });
        } else {
            $('#export_excel').prop("disabled", true);
            $("#filter_results tr td .md-check").each(function() {
                this.checked = false;
            });
        }
    });

$('#export_excel').click(function() {
if (confirm('voulez vous vraiment exporter cette liste ?')) {
    var ids_client = [];
    var ids_client_sep = "";
    var cnt = 0;
         $('input:checked[name="Choix[]"]').each(function() {
            if (cnt != 0) {
                ids_client_sep += "_";
            }
            ids_client_sep += $(this).val();
            ids_client.push(parseInt($(this).val()));
            cnt++;            
        });
        //alert(ids_client_sep);
     window.open("<?php echo site_url('payments/export_excel'); ?>/" + ids_client_sep,
            "_blank"); 
            $('input[name="Choix[]"]').prop("checked", false);
            $('#export_excel').prop('disabled', true);
            $('#check_all').prop("checked", false);
             // Opens a new window   

    //   window.open("<?php echo site_url('clients/export_excel'); ?>/" + ids_client_sep,
    //     "_blank"); // Opens a new window
};
})

$("#select_all").change(function() {
    $('#export_excel').prop("disabled", false);
    $("#filter_results tr td .md-check").each(function() {
        this.checked = true;
    });
    
    window.open("<?php echo site_url('payments/export_excel'); ?>/all",
            "_blank");
            $('#check_all').prop("checked", false);
            $('input[name="Choix[]"]').prop("checked", false);
            $('#select_all').prop("checked", false);
            $('#export_excel').prop('disabled', true);        
})


</script>