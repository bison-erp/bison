<head>
    <style>
    .nav>li>a {
        position: relative;
        display: block;
        padding: 5px 5px;
    }

    #sample_editable_1 thead tr th {
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
    }

    #sample_editable_1 {
        table-layout: fixed;
    }

    #sample_editable_1 tbody tr:hover {
        background: aliceblue;
    background: #f1f1f1;
    }
    </style>
</head>
<div id="headerbar" class="headerbar contact" style=" margin-top:0">
    <form class="navbar-form navbar-left search_in_list" role="search" style="height: 25px;margin-left: 10%;">
        <div class="form-group">
            <input id="filter_clients" type="text" class="search-query form-control input-sm"
                placeholder="<?php echo $filter_placeholder; ?>" style="height: 25px;">
        </div>
    </form>
    <?php
$sess_cont_add = $this->session->userdata['cont_add'];
$sess_cont_del = $this->session->userdata['cont_del'];
$sess_cont_index = $this->session->userdata['cont_index'];

if ($sess_cont_add == 1) {
    ?>
    <div class="pull-right contact" style="margin: 15px 7px;">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg" data-toggle="collapse"
            data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i><?php echo lang('submenu'); ?>
        </button>
        <a class="btn btn-primary btn-light-success no-marg" href="<?php echo site_url('clients/form'); ?>">
            <!--i class="fas fa-pen-square"></i--><?php echo lang('create_client'); ?>
        </a>
    </div>
    <?php }?>
    <div class="pull-right visible-lg" style="margin: 15px 7px;">
        <ul class="nav nav-pills index-options">
            <li>
                <!--a href="javascript:;" class="filter_statut" data="0"><!--?php echo lang('prospect_filter'); ?>
                    <span class="badge badge-primary"><!--?php echo $data->somme0; ?></span>
                </a-->	
				<div class="btn btn-icon w-auto btn-clean d-inline-flex align-items-center btn-lg">
					<a href="javascript:;" class="btn-light-primary filter_statut" data="0"><?php echo lang('prospect_filter'); ?></a>
					 <span class="symbol symbol-light-warning"><?php echo $data->somme0; ?></span>
				</div>
            </li>
            <li>
                <!--a href="javascript:;" class="filter_statut" data="1"><!--?php echo lang('client_filter'); ?> <span
                        class="badge badge-primary"><!--?php echo $data->somme1; ?></span></a-->	
				<div class="btn btn-icon w-auto btn-clean d-inline-flex align-items-center btn-lg">
					<a href="javascript:;" class="btn-light-primary filter_statut" data="1"><?php echo lang('client_filter'); ?></a>
					 <span class="symbol symbol-light-warning"><?php echo $data->somme1; ?></span>
				</div>
            </li>
            <li class="active">
                <!--a href="javascript:;" class="filter_statut" data="a"><!--?php echo lang('all'); ?> <span
                        class="badge badge-primary"><!--?php echo $data->somme; ?></span></a-->
				<div class="btn btn-icon w-auto btn-clean d-inline-flex align-items-center btn-lg">
					<a href="javascript:;" class="btn-light-primary filter_statut" data="a"><?php echo lang('all'); ?></a>
					 <span class="symbol symbol-light-warning"><?php echo $data->somme; ?></span>
				</div>
            </li>
        </ul>
    </div>
    <?php
if (getGroupuser($this->session->userdata['user_id']) == 0) {?>
    <div class="pull-right" style="margin: 15px 7px;">
        <button
            style="padding: 3px 10px 5px;margin-right: 20px; margin-top: 1px; background-color: #2EB2E6; color: #fff;"
            id="export_excel" class="btn btn-sm btn export-excel">
            <!--i class="fa fa-file-excel-o"></i--><i class="fas fa-file"></i><?php echo lang('exporter') ?>
        </button>
    </div>
    <?php }?>
</div>
<div style="clear:both"></div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts');?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="table-scrollable" style=" width: 100%; border:none!important;">
                    <table class="table table-striped table-hover table-responsive" id="sample_editable_1">
                        <thead>
                            <tr>
                                <th width="160" order="client_name"><?php echo lang('client_name_table'); ?></th>
                                <th width="50" order="client_id"><?php echo lang('code'); ?></th>
                                <th width="140" order="client_societe" style=""><?php echo lang('client_raison_tab'); ?>
                                </th>
                                <th width="150" order="client_email" style=""><?php echo lang('client_email_tab'); ?>
                                </th>
                                <th width="120" order="client_phone" style=""><?php echo lang('client_telFix_tab'); ?>
                                </th>
                                <th width="120" order="client_mobile" style="">
                                    <?php echo lang('client_telmobile_tab'); ?></th>
                                <th width="100" order="client_web" style=""><?php echo lang('client_webSite_tab'); ?>
                                </th>
                                <th width="150" order="devise_symbole,solde" style="text-align: right;">
                                    <?php echo lang('balance'); ?></th>
                                <th width="80" order="client_type" style=""><?php echo lang('client_type'); ?></th>
                                <th width="50" style="">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="check_all" class="md-check">
                                        <label for="check_all">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>

                                </th>
                                <th width="50" style="white-space:nowrap;" align="right">
                                    <div class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            href="#">
                                            <i class="fa fa-cog"></i> <?php // echo lang('options');     ?>
                                        </a>
                                        <ul class="dropdown-menu dropdown-btngroup-menu">
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
<!-- pagination -->
<div class="pag-table-content">
    <div class="pull-right">
        <select class="btn btn-default btn-sm bg-light-primary pagin" id="clients_par_page">
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
</div>


<input type='hidden' value='0' id='etatselect'>
<?php
$this->db->set('ip_clients.client_type', 0);
$this->db->update('ip_clients');

$this->db->select("ip_clients.client_id as clid");
$this->db->from('ip_clients');
$clients = $this->db->get()->result();

$array = array(
    'client_type' => 1,
);

foreach ($clients as $row) {
    $this->db->select('ip_invoices.client_id');
    $this->db->from('ip_invoices');
    $this->db->WHERE("ip_invoices.client_id", $row->clid);
    $invoice_id = $this->db->get()->result();

    if (count($invoice_id) > 0) {
        $this->db->set($array);
        $this->db->where('ip_clients.client_id', $row->clid);
        $this->db->update('ip_clients');
    }
    if (count($invoice_id) == 0) {
        $this->db->select('ip_payments.client_id');
        $this->db->from('ip_payments');
        $this->db->WHERE("ip_payments.client_id", $row->clid);
        $quote_id = $this->db->get()->result();
        if (count($quote_id) > 0) {
            $this->db->set($array);
            $this->db->where('ip_clients.client_id', $row->clid);
            $this->db->update('ip_clients');
        }
    }
}
?>
<script type="text/javascript">
$('#check_all').prop('checked', false);
$('#aa').prop('checked', false);

$('#export_excel').prop('disabled', true);

$(function() {
    start_page = 1;
    limit_par_page = 20;
    nb_pages = 1;
    order_by = "client_id";
    order_method = "desc";
    if (typeof(page) == 'undefined') {
        page = 1;
    }

    if (typeof(filter_statut) == 'undefined') {
        filter_statut = "a";
    }

    if (typeof(filter_client) == 'undefined') {
        filter_client = $("#filter_clients").val();
    }
    filterClient();


    $('#export_excel').click(function() {

        if (confirm('voulez vous vraiment exporter cette liste ?')) {

            var ids_client = [];
            var ids_client_sep = "";
            var cnt = 0;
            if ($('#etatselect').val() == 0) {
                $('input:checked[name="Choix[]"]').each(function() {

                    if (cnt != 0) {
                        ids_client_sep += "_";
                    }
                    ids_client_sep += $(this).val();
                    ids_client.push(parseInt($(this).val()));
                    cnt++;
                });
                window.open("<?php echo site_url('clients/export_excel'); ?>/" + ids_client_sep,
                    "_blank"); // Opens a new window
            } else {
                //Choixtou

                $.post("<?php echo site_url('clients/ajax/getContact'); ?>", function(data) {

                  /*  var quote_all = JSON.parse(data);

                    for (i = 0; i < quote_all.length; i++) {
                        if (i == quote_all.length - 1) {
                            ids_client_sep += quote_all[i][
                                'client_id'
                            ]
                        } else {
                            ids_client_sep += quote_all[i]['client_id'] + "_";
                        }
                    }
                    window.open("<?php echo site_url('clients/export_excel'); ?>/" +
                        ids_client_sep,
                        "_blank"); // Opens a new window
                        */

                        window.open("<?php echo site_url('clients/export_excel/all'); ?>",  
                         
                        "_blank"); // Opens a new window    

                })


            }


            //   window.open("<?php echo site_url('clients/export_excel'); ?>/" + ids_client_sep,
            //     "_blank"); // Opens a new window
        };
    })

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

    $("#filter_clients").keyup(function() {
        filter_client = $(this).val();
        start_page = 1;
        nb_pages = 1;
        filterClient();
    });
    $(".filter_statut").click(function() {
        filter_statut = $(this).attr("data");
        $(".filter_statut").parent().removeClass("active");
        $(this).parent().addClass("active");
        start_page = 1;
        nb_pages = 1;
        filterClient();

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
        filterClient();
    });

    $("#sample_editable_1 thead tr th").click(function() {
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
            filterClient();
        }

    });

    $("#clients_par_page").change(function() {
        start_page = 1;
        limit_par_page = $(this).val();
        filterClient();
    });




    function filterClient() {
        $('#filter_results').load(
            "<?php echo site_url('clients/ajax/load_clients_partial_filter'); ?>/" + Math
            .floor(Math.random() * 1000), {
                filter_statut: filter_statut,
                filter_client: filter_client,
                limit_par_page: limit_par_page,
                start_page: start_page,
                order_by: order_by,
                order_method: order_method

            });
    }
});

$("#select_all").change(function() {
    if ($('#aa').prop("checked")) {
        $('#etatselect').val(1);
        $('input[name="Choix[]"]').each(function() {
            $(this).prop('checked', 'checked');
        });

        $('#relance_rappel').prop("disabled", false);
        $('#export_excel').prop("disabled", false);
        $.post("<?php echo site_url('clients/ajax/getContact'); ?>", function(data) {
            var quote_all = JSON.parse(data);
            //   $('#check_all').prop('checked', 'checked');
            $('input[type="checkbox"]').prop('checked', 'checked');

            if ($('input[name="Choixtou[]"]').is(':checked')) {

            } else {

                for (i = 0; i < quote_all.length; i++) {
                    $(".selectinput").append(



                        '<input type = "checkbox" name = "Choixtou[]" value = "' +
                        quote_all[i]['quote_id'] +
                        ' "  class = "md-check" checked hidden>'
                    );
                }
            }
        })
    } else {
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);
        $('input[type="checkbox"]').prop('checked', false);
        $('#etatselect').val(0);
    }

})


$("#check_all").click(function() {
    if ($(this).is(':checked')) {
        $('#relance_rappel').prop("disabled", false);
        $('#export_excel').prop("disabled", false);
        $("#filter_results tr td .md-check").each(function() {
            this.checked = true;
        });
    } else {
        $('#relance_rappel').prop("disabled", true);
        $('#export_excel').prop("disabled", true);
        $("#filter_results tr td .md-check").each(function() {
            this.checked = false;
        });
    }
});
</script>