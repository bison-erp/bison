<div id="modal_change_statut_quote" class="modal col-xs-12" role="dialog" aria-hidden="true"
    style="overflow: hidden;height: 400px;z-index: 10050 !important;display: block; width: 400px; margin: 20px auto;">
    <form class="modal-content">
        <div class="modal-header" style=" height: 50px !important;border-bottom: 1px solid #E5E5E5;width: 360px;">
            <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                style="width: 22px;height: 20px;color: #FFF !important;background-image: none !important; background-color: rgb(220, 53, 88) !important;text-align: center;text-indent: 0px;opacity: 1;">
                <i class="fa fa-close"></i></button>

            <div class="col-md-10" style=" font-weight: 600;font-size: 20px;margin-bottom: 14px;text-align: center;">
                <?php

if ($type == 0) {?>
                fabrication Statut
                <?php } else {?>
                BL Statut
                <?php }?>
            </div>
        </div>
        <div class="modal-body" style="margin-top: 70px;">
            <div class="row">
                <div class="col-md-12" style=" font-weight: 600;font-size: 15px;text-align: center;">
                    <?php if ($type == 0) {?>
                    Changement status de fabrication #<?php echo $fabrication->fabrication_number; ?>
                    <?php } else {?>
                    Changement status de BL #<?php echo $quote->invoice_id; ?>
                    <?php }?>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 10px;">
                <br>
                <div class="col-md-12" style="font-weight: bold;" id="list_statuses">

                    <?php

foreach ($quote_statuses as $key => $value) {
    ?>

                    <div class="row">

                        <div class="col-md-6 <?php echo $value['class'] ?>"
                            style="line-height:30px; padding-left:30px;">
                            <input type='radio' class="icheck statuses_check" name="status" <?php
if ($type == 0) {
        if ($fabrication->fabrication_status_id == $key) {
            echo "checked";
        }} else {
        if ($quote->invoice_status_id == $key) {
            echo "checked";
        }
    }?> value="<?php echo $key; ?>" data-class_status="<?php echo $value['class'] ?>"
                                data-label_status="<?php echo $value['label'][0] ?>">
                             <?php
if (($type == 1) && ($value['label'] == "Validé")) {
        echo "Payée";
    } else {
        echo $value['label'];
    }
    ;
    ?>
                        </div>
                        <?php if ($key == 4) {
        ?>
                        <div class="col-md-6" id="display_date" <?php

        if ($type == 0) {
            if ($fabrication->fabrication_status_id == $key) {
                echo "style='display:none;'";
            }} else {
            if ($quote->invoice_status_id == $key) {
                echo "style='display:none;'";
            }
        }

        ?>>
                            <?php if ($type == 0) {?>
                            <input type='text' id="data_accepte" class="form-control input-sm datepicker" value="<?php if ($fabrication->fabrication_date_accepte != "0000-00-00") {echo date_from_mysql($fabrication->fabrication_date_accepte, 1);
        } elseif ($type == 0) {
            if ($fabrication->fabrication_status_id != 4) {
                if ($fabrication->fabrication_date_accepte != "0000-00-00") {
                    echo date($fabrication->fabrication_date_accepte);
                } else {
                    echo date("d/m/Y");
                }
            } else {
                echo date("d/m/Y");
            }
        } else {
            if ($quote->invoice_status_id != 4) {
                if ($quote->quote_date_accepte) {
                    echo date($quote->quote_date_accepte);
                } else {
                    echo date("d/m/Y");
                }
            } else {
                echo date("d/m/Y");
            }
        }

            ?>">
                            <?php } else {?>
                            <input type='text' id="data_accepte" class="form-control input-sm datepicker"
                                value="<?php echo date("d/m/Y"); ?>">

                            <?php }?>



                        </div>
                        <?php }?>
                    </div>
                    <?php }?>

                </div>
            </div>

            <input type="hidden" id="id_quote_to_change_status" value="<?php
if ($type == 0) {
    echo $fabrication->fabrication_id;
} else {
    echo $quote->invoice_id;
}
?>">
            <input type="hidden" id="id_status_anc" value="<?php
if ($type == 0) {
    echo $fabrication->fabrication_status_id;
} else {
    echo $quote->invoice_status_id;
}
?>" data-class_status="<?php
if ($type == 0) {
    echo $quote_statuses[$fabrication->fabrication_status_id]['class'];
} else {
    echo $quote_statuses[$quote->invoice_status_id]['class'];
}

?>" data-label_status="<?php
if ($type == 0) {
    echo $quote_statuses[$fabrication->fabrication_status_id]['label'][0];
} else {
    echo $quote_statuses[$quote->invoice_status_id]['label'][0];
}
?>">
        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn  defult" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn  blue btn-success" id="change_status_quote" type="button">
                    <i class="fa fa-check"></i> Changer status
                </button>
            </div>
        </div>

    </form>
    <input type='hidden' id='type' value="<?php echo $type ?>">

</div>
<link href="<?php echo base_url(); ?>assets/global/plugins/icheck/skins/all.css" rel="stylesheet" />
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/icheck/icheck.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/form-icheck.js"></script>


<script>
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Demo.init(); // init demo features
    FormiCheck.init(); // init page demo
});
</script>
<script>
$(function() {

    $('#modal_change_statut_quote').modal('show');
    $(".close").click(function() {
        $('#modal_change_statut_quote').modal('hide');
    });



    $(".iCheck-helper").click(function() {
        var id_selected_status = $("#list_statuses input[type=radio]:checked").val();
        if (id_selected_status == "4") {
            $("#display_date").show();
        } else {
            $("#display_date").hide();
        }
    });

    $("#change_status_quote").click(function() {

        var id_fabrication = $("#id_quote_to_change_status").val();
        var data_accepte = $("#data_accepte").val();

        var id_status_anc = $("#id_status_anc").val();
        var id_class_anc = $("#id_status_anc").data("class_status");
        var id_label_anc = $("#id_status_anc").data("label_status");

        var id_selected_status = $("#list_statuses input[type=radio]:checked").val();
        var id_selected_class = $("#list_statuses input[type=radio]:checked").data("class_status");
        var id_selected_label = $("#list_statuses input[type=radio]:checked").data("label_status");

        $.post("<?php echo site_url('fabrication/ajax/updateStatutfabrication'); ?>", {
            id_selected_status: id_selected_status,
            data_accepte: data_accepte,
            id_fabrication: id_fabrication,
            type: $('#type').val()
        }, function(data) {
            if ($('#type').val() == 1) {
                if ($('#type').val() == 1 && (id_selected_class.search("approved") == 0)) {
                    $("#line_" + id_fabrication + " .change_quote_statuses1").html('P');
                    $("#line_" + id_fabrication + " .change_quote_statuses1").removeClass(
                        id_class_anc);
                    $("#line_" + id_fabrication + " .change_quote_statuses1").addClass(
                        id_selected_class);
                    //    alert(id_selected_class);
                    //  alert('facture');
                } else {
                    $("#line_" + id_fabrication + " .change_quote_statuses1").removeClass(
                        id_class_anc);
                    $("#line_" + id_fabrication + " .change_quote_statuses1").removeClass(
                        'paid ');

                    $("#line_" + id_fabrication + " .change_quote_statuses1").html(
                        id_selected_label);
                    $("#line_" + id_fabrication + " .change_quote_statuses1").addClass(
                        id_selected_class);
                    //  alert(id_selected_class);
                    //  alert('facture');
                }
            }
            if ($('#type').val() == 0) {
                //alert('devis');
                $("#line_" + id_fabrication + " .change_fabrication_statuses").html(id_selected_label);
                $("#line_" + id_fabrication + " .change_fabrication_statuses").removeClass(id_class_anc);
                $("#line_" + id_fabrication + " .change_fabrication_statuses").addClass(
                    id_selected_class);
            }
            $('#modal_change_statut_quote').modal('hide');

        });

    });
});
</script>