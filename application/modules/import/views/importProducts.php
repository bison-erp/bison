<style>
    .form-control {
        display: block;
        width: 150px!important; 
        height: 34px!important; 
        padding: 2px 3px!important; 
        font-size: 14px!important;
        line-height: 14px!important; 
    }
    .form-group.form-md-line-input {
        margin:10px 0!important; 
        padding-top: 0!important; 
    }
    .config_import tr{
        /*border-bottom:#DDD solid 1px;*/
    }
    .menu_selected{
        background-color:#DDD!important;
    }
    .line_error{
        background-color:#f2dede!important;

    }

    .line_error td:first-child {
        border-left:#D00 solid 2px!important;
    }
    .table-scrollable{
        overflow-y:auto!important;
        height:400px!important;
    }
    .log_error{
        color:red;
    }
    .log_warning{
        color:#987300;
    }
    .log_success{
        color:green;
    }


</style>
<?php
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle = $worksheet->getTitle();
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    $database_fields = array(
        array("name" => "family_name", "title" => "Nom de famille"),
        array("name" => "product_sku", "title" => "Référence"),
        array("name" => "product_name", "title" => "Nom du produit"),
        array("name" => "product_description", "title" => "Description du produit"),
        array("name" => "purchase_price", "title" => "Prix d'achat"),
        array("name" => "product_price", "title" => "Prix de vente"),
        array("name" => "tva", "title" => "TVA"),
    );
    ?>
<div id="headerbar-index">
    <?php $this->layout->load_view('layout/alerts'); ?>
</div>
<div id="content">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Config importation</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">
                    <table width="100%" class="config_import">
                        <tr>
                            <td width="200">N° Ligne de l'entête du fichier</td>
                            <td style="text-align: left">
                                <div class="form-group form-md-line-input has-info">
                                    <select id="select_menu" class="form-control">
                                        <?php for ($x = 1; $x <= $highestRow; ++$x) { ?>

                                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option> 

                                            <?php
                                            if ($x >= 5)
                                                break;
                                        }
                                        ?>
                                    </select>
                                </div>

                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <hr>
            <div class="row">
                <?php foreach ($database_fields as $field) { ?>
                    <div class="col-md-4">
                        <table width="100%" >
                            <tr>
                                <td width="200"><?php echo $field["title"]; ?> </td>
                                <td style="text-align: left">
                                    <div class="form-group form-md-line-input has-info">
                                        <select class="form-control fields_import" id="db_field_<?php echo $field["name"]; ?>">

                                        </select>
                                    </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>

            </div>

            <div class="row">

            </div>

        </div>
    </div>
    <div class="pull-right" style="margin-bottom:20px;">
        <div class="btn-group">
            <button class="btn blue dropdown-toggle" data-toggle="dropdown">Mise à jours les Familles <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu ">

                <li>
                    <a  onclick="updateProductsFamilyValue('0')">
                        Mise à jour fichier à importer</a>
                </li>
                <li>
                    <a  onclick="updateProductsFamilyValue('1')">
                        Insérer les familles manquants</a>
                </li>

            </ul>
        </div>
        <button class="btn green" onclick="verif_fields()">Vérification</button>
        <button class="btn" onclick="import_fields()">Import</button>
    </div>
    <div class="clearfix"></div>

    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Liste des contacts à importer</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover table_import">
                    <tbody>
                        <?php
                        for ($row = 1; $row <= $highestRow; ++$row) {
                            echo '<tr  id="line_' . $row . '">';
                            echo '<td>' . $row . '</td>';
                            echo '<td>';
                            echo '<input type="checkbox" id="check_' . $row . '" checked="checked">';
                            echo '</td>';
                            echo '<td>';
                            echo '<select id="family_id_' . $row . '" style="width:150px;">';
                            echo '<option value="-1">Sélectionner</option>';
                            ?>
                            <?php
                            if (!empty($families)) {
                                foreach ($families as $family) {
                                    ?>
                                <option value="<?php echo $family->family_id ?>"><?php echo $family->family_name; ?></option>
                                <?php
                            }
                        }
                        echo '</select>';
                        echo '</td>';
                        for ($col = 0; $col < $highestColumnIndex; ++$col) {
                            $cell = $worksheet->getCellByColumnAndRow($col, $row);
                            if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                $val = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
                            } else {
                                $val = $cell->getValue();
                            }
                            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                            echo '<td><input class="val_line row_' . $row . '" type="text" id="num_' . $row . '_' . $col . '" value="' . $val . '"></td>';
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="portlet light" style="display:none;">
        <div class="portlet-body" id="scroll" style="height: 200px;max-height: 200px; overflow-y: overlay;">
            <p id="console_log" style="line-height:16px; font-size: 12px;">

            </p>
        </div>
    </div>

<?php } ?>

<script>
    function updatefieldsMenu() {
        var line_menu = $("#select_menu").val();
        var options = "<option value=''>Selectionner</option>";
        $("#line_" + line_menu + " .val_line").each(function () {
            var value_field = $(this).val();
            var id_arr = $(this).attr("id").split("_");
            var id_opt = id_arr[2];

            options += "<option value='" + id_opt + "'>" + value_field + "</option>";
        });

        $(".fields_import").each(function () {
            var select1 = $(this);
            select1.html(options);

        });
        $(".table_import tbody tr").each(function () {
            var line_value = $(this).attr("id").substr(5);

            if (line_value == line_menu) {
                $(this).addClass('menu_selected');
                $("#check_" + line_value).css("display", "none");
                $("#family_id_" + line_value).css("display", "none");
            }
            else {
                $(this).removeClass('menu_selected');
                $("#check_" + line_value).css("display", "inherit");
                $("#family_id_" + line_value).css("display", "inherit");
            }
        });

    }

    function scrollToLog() {
        $('#scroll').scrollTop($('#scroll').prop('scrollHeight'));
        $("body").scrollTop($("body").prop('scrollHeight'));
    }
    function verif_fields() {

        var import_fields = {};
        var total_errors_count = 0;
        var line_menu = $("#select_menu").val();
        $(".table_import input[type=checkbox]:checked").each(function () {
            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {
                import_fields[curr_line] = {};
                $(".fields_import").each(function () {
                    var field_db_selected = $(this).val();

                    if (field_db_selected != "") {
                        var field_db = $(this).attr("id").substr(9);
                        var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                        import_fields[curr_line][field_db] = value_db;
                    }
                });

            }
        });
        $.post("<?php echo site_url('import/ajax/verifProducts'); ?>", {
            "import_fields": import_fields
        }, function (data) {
            $("#console_log").parent().parent().show();
            $(".line_error").each(function () {
                $(this).removeClass("line_error");
            });

            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            var errors_cons = json_response[2];
            var errors_cons2 = json_response[1];
            var date_exec = json_response[0];


            total_errors_count = errors_cons.length + errors_cons2.length;
            $("#console_log").append("<span style=''>" + date_exec + " Vérification du fichier à importer ...</span> (" + total_errors_count + " erreurs)<br>");
            $.each(errors_cons, function (key, value) {
                $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");
            });

            $.each(errors_cons2, function (key, value) {
                var val2 = value.split("_");
                $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le produit #" + val2[0] + " à importer existe déja. il est equivalent au produit <a href='<?php echo base_url(); ?>products/form/" + val2[1] + "' target='_blank'>#" + val2[2] + "</a> . </span><br>");
                $("#line_" + val2[0]).addClass("line_error");

            });

            $("#console_log").append("<hr style='margin:5px 0;'>");
            scrollToLog();
        });

    }

    function updateProductsFamilyValue(type) {
        var import_fields = {};
        var line_menu = $("#select_menu").val();
        var exist_field = 0;

        $(".table_import input[type=checkbox]").each(function () {

            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {

                if ($("#family_id_" + curr_line).val() == "-1") {
                    import_fields[curr_line] = {};
                    $(".fields_import").each(function () {
                        var field_db_selected = $(this).val();

                        if (field_db_selected != "") {
                            var field_db = $(this).attr("id").substr(9);
                            if (field_db == "family_name") {
                                var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                                import_fields[curr_line][field_db] = value_db;
                               
                            }
                        }
                    });
                }
                 exist_field = 1;
            }
        });


        if (exist_field == 1) {
            $.post("<?php echo site_url('import/ajax/updateProductsFamilyValue'); ?>", {
                "import_fields": import_fields,
                "type": type,
            }, function (data) {
                var cnt = 0;
                var parsed = JSON.parse(data);
                json_response = [];
                for (var x in parsed) {
                    json_response.push(parsed[x]);
                }
                var equivs = json_response[0];
                var date_exec = json_response[1];

                $.each(equivs, function (key, value) {
                    var equiv = value.split("_");
                    var id_line = equiv[0];
                    var id_family = equiv[1];


                    $.post("<?php echo site_url('import/ajax/updateFamilies'); ?>", {
                        'update_families': 1
                    }, function (data) {
                        var parsed1 = JSON.parse(data);
                        json_response1 = [];
                        for (var x in parsed1) {
                            json_response1.push(parsed1[x]);
                        }
                        var families = json_response1[0];
                        var select_families = '<option value="-1">Sélectionner</option>';
                        $.each(families, function (key, value) {
                            if (id_family == value['family_id']) {
                                select_families += '<option value="' + value['family_id'] + '" selected="selected">' + value['family_name'] + '</option>';
                            }
                            else
                            {
                                select_families += '<option value="' + value['family_id'] + '">' + value['family_name'] + '</option>';
                            }

                        });
                        $("#family_id_" + id_line).html(select_families);
                    });

                    cnt++;

                });
                $("#console_log").parent().parent().show();
                $("#console_log").append("<span style=''>" + date_exec + " Mise à jour liste des familles ...</span> <br>");
                $("#console_log").append("<span class='log_success' style='margin-left:20px;'>" + cnt + " produits ont été mise à jour.</span> <br>");
                scrollToLog();
                $(".table_import input[type=checkbox]").each(function () {
                    var curr_line = $(this).attr("id").substr(6);
                    if (curr_line != line_menu) {
                        if ($("#id_family" + curr_line).val() == -1 && $("#check_" + curr_line + ":checked").length > 0) {
                            $("#line_" + curr_line).addClass("line_error");
                        } else {
                            $("#line_" + curr_line).removeClass("line_error");
                        }
                    }
                });
            });
        }
        else {
            alert("Veuillez Selectionner le champ des familles");
        }

    }



    function import_fields() {
        var msg_console = "<span style=''>Loading module import ...</span><br>";
        $("#console_log").parent().parent().show();
        $("#console_log").append(msg_console);



        /// Insertion des clients

        var import_fields = {};
        var line_menu = $("#select_menu").val();
        $(".table_import input[type=checkbox]:checked").each(function () {
            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {
                import_fields[curr_line] = {};
                $(".fields_import").each(function () {
                    var field_db_selected = $(this).val();

                    if (field_db_selected != "") {
                        var field_db = $(this).attr("id").substr(9);
                        var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                        import_fields[curr_line][field_db] = value_db;
                        if (field_db == "family_name") {
                            import_fields[curr_line]["family_id"] = $("#family_id_" + curr_line).val();
                        }
                    }
                });

            }
        });

        $.post("<?php echo site_url('import/ajax/importProducts'); ?>", {
            "import_fields": import_fields,
            "file_id": <?php echo $file_id; ?>
        }, function (data) {

            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            var errors_cons = json_response[2];
            var errors_cons2 = json_response[1];
            var date_exec = json_response[0];
            var success = json_response[3];
            var errors2 = json_response[4];
            if (success == 1) {
                messages_console = "<span style='margin-left:20px;' class='log_success'>Importation effectué avec succèes.</span><br>";
                $("#console_log").append(messages_console);
            }
            else {
                total_errors_count = errors_cons.length + errors_cons2.length;
                $("#console_log").append("<span style=''>" + date_exec + " Vérification du fichier à importer ...</span> (" + total_errors_count + " erreurs)<br>");
                $.each(errors_cons, function (key, value) {
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");
                });
                $.each(errors2, function (key, value) {
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- " + value + "</span><br>");
                });

                $.each(errors_cons2, function (key, value) {
                    var val2 = value.split("_");
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le produit #" + val2[0] + " à importer existe déja. il est equivalent au produit <a href='<?php echo base_url(); ?>products/form/" + val2[1] + "' target='_blank'>#" + val2[2] + "</a> . </span><br>");
                    $("#line_" + val2[0]).addClass("line_error"); 

                });
            }
scrollToLog();
        });







//        $("#console_log").append("<hr style='margin:5px 0;'>");
//        $('#scroll').scrollTop($('#scroll').prop('scrollHeight'));
//        $("body").scrollTop($("body").prop('scrollHeight'));



    }


    $(function () {
        updatefieldsMenu();
        $("#select_menu").change(function () {
            updatefieldsMenu();
        });
    });
</script>