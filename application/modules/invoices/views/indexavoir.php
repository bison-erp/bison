<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<style>
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 2s linear infinite;
    position: relative;
    top: -650px;
    left: 600px;
}

/* Safari */
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

/*.label{font-weight:normal;padding:.3em .6em;color:white !important;display:block;width:100%;}*/
.label.label-inline {
    display: inline;
    width: auto
}

.table>tbody>tr>td {
    white-space: nowrap;
    vertical-align: middle;
}

#invoice_all thead tr th {
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
}

#invoice_all {
    table-layout: fixed;
}

#invoice_all tbody tr:hover {
    background: aliceblue;
}


/*#invoice_all{table-layout:fixed;}*/
</style>
<?php
$max = $query_max_dat[0]->invoice_date_created;
$max_yer = explode('-', $max);
$max_y = $max_yer[0];
if (date('Y') > $max_y) {
    $max_y = date('Y');
}
$min = $query_min_dat[0]->invoice_date_created;
$min_yer = explode('-', $min);
$min_y = $min_yer[0];

?>
<div id="headerbar">
    <?php
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];
//echo '<pre>';
//print_r($this->session->userdata);
//echo '</pre>';
?>

    <table style=" width:100%; margin-top: 0px;">
        <tr>
            <td align="right" class="form-widh avoirs" style=" width:30%">
                <form class="navbar-form navbar-left search_in_list" role="search" style="padding:0;">
                    <div class="form-group">
                        <input id="filter_invoices" style="padding: 0px;" type="text"
                            class="search-query form-control input-sm" placeholder="<?php echo $filter_placeholder; ?>">
                    </div>
                </form>

            </td>
            <td align="center" style=" width:12%">
                <select class="form-control select_filter" id="select_filter_user">
                    <option value="0"><?php echo lang('filter_user'); ?></option>
                    <?php foreach ($users as $user) {?>
                    <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php }?>
                </select>
            </td>
            <td align="center" style=" width:12%">
                <select class="form-control select_filter" id="select_filter_date">
                    <option value="all"><?php echo lang('year'); ?></option>
                    <?php
$min_y = intval($min_y) == 0 ? date("Y") : $min_y;
$max = intval($max) == 0 ? date("Y") : $max;
for ($i = $min_y; $i <= $max; $i++) {?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>

            </td>

            <td align="right" style=" width:70%">


                <?php if ($sess_devis_add == 1) {?>
                <div class="pull-right" style="margin:2px 0;">
                    <button type="button" style=" padding: 3px 6px 8px 7px !important; display: none"
                        class="btn btn-default btn-sm submenu-toggle hidden-lg" data-toggle="collapse"
                        data-target="#ip-submenu-collapse">
                        <i class="fa fa-bars"></i> <?php echo lang('submenu'); ?>
                    </button>

                </div>
                <?php }?>
            </td>

        </tr>
    </table>

    <div style="clear:both"></div>


</div>

<form action="<?php echo site_url('mailer/relance'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
         <!--   <div class="portlet light" style="margin-left: 1%;" >-->
            <div class="portlet light">
                <div id="content" class="table-content">
                    <?php // $this->layout->load_view('layout/alerts'); 
                  
                    ?>

                    <div class="table-scrollable" style=" width: 100%; border:none!important;">
                        <table class="table table-striped table-hover table-responsive" id="invoice_all">
                            <thead>
                                <tr>
                                    <th  width="50" order="ip_haveinvoices.invoice_number">
                                        <?php echo lang('num_devis'); ?></th>                             
                                    <th width="100" order="ip_haveinvoices.invoice_date_created">
                                        <?php echo lang('created'); ?></th>
                                    <th  width="100" order="ip_haveinvoices.date_create_avoir_invoice"><?php echo lang('due_date'); ?>
                                    </th>
                                    <th width="150" order="client_societe2"><?php echo lang('client_filter'); ?></th>
                                    <th width="50" order="client_country"><?php echo lang('client_pays'); ?></th>
                                    <th width="150" order="ip_haveinvoices.nature"><?php echo lang('quote_nature'); ?></th>
                                    <th width="100" order="invoice_item_subtotal_final"><?php echo lang('amount_ht'); ?>
                                    </th>
                                    <th width="100" order="invoice_total"><?php echo lang('amount_ttc'); ?></th>
                                    <th width="50" order="invoice_item_tax_total"><?php echo lang('taxes'); ?>
                                    </th>
                                    <th width="50"> </th>
                                    <th width="50"> </th>
                                    <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
                                    <th width="50" ></th>
                                    
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
</form>
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" style="background:#FFF;" id="invoices_par_page">
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
<div class="loader"></div>

<input type='hidden' value='0' id='etatselect'>

<script type="text/javascript">
$('.loader').hide();
$(function() {
    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "ip_haveinvoices.invoice_number";
    order_method = "desc";
    if (typeof(page) == 'undefined') {
        page = 1;
    }
    if (typeof(filter_user_id) == 'undefined') {
        filter_user_id = "0";
    }
    if (typeof(filter_date) == 'undefined') {
        filter_date = "all";
    }
    if (typeof(filter_statuts) == 'undefined') {
        filter_statuts = "all";
    }
    if (typeof(filter_invoice) == 'undefined') {
        filter_invoice = "";
    }


    $("#check_all").click(function() {
        if ($(this).is(':checked')) {
            $("#filter_results tr td .md-check").each(function() {
                this.checked = true;
            });
        } else {
            $("#filter_results tr td .md-check").each(function() {
                this.checked = false;
            });
        }
    });


    $('#filter_invoices').keyup(function() {
        filter_invoice = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();

    });
    $('#select_filter_user').change(function() {
        filter_user_id = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();

    });
    $('#select_filter_date').change(function() {
        filter_date = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();
    });
    $('#select_filter_statuts').change(function() {
        filter_statuts = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterInvoices();
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
        filterInvoices();
    });
    $("#invoices_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterInvoices();
    });

    $("#invoice_all thead tr th").click(function() {
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
            filterInvoices();
        }

    });

    filterInvoices();

    function filterInvoices() {
        //            $('#filter_results').html("<tr><td colspan='13'> Loading...</td></tr>");
        $('#filter_results').load("<?php echo site_url('invoices/ajax/haveinvoice_partial_filter'); ?>/" +
            Math.floor(Math.random() * 1000), {
                filter_user_id: filter_user_id,
                filter_invoice: filter_invoice,
                filter_date: filter_date,
                filter_statuts: filter_statuts,
                limit_par_page: limit_par_page,
                start_page: start_page,
                order_by: order_by,
                order_method: order_method
            },
            function(data) {}, 500);
    }
});
</script>
<input type="hidden" id="selected_dates" value="" />
<input type="hidden" id="selected_dates_bool" value="" />