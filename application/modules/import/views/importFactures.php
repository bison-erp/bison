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
    .log_error, .error_field{
        color:red!important;
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
        0 => array("name" => "invoice_number", "title" => "Numéro facture"),
        1 => array("name" => "client_name", "title" => "Client"),
        2 => array("name" => "invoice_date_created", "title" => "Date création"),
        3 => array("name" => "invoice_date_modified", "title" => "Date modification"),
        4 => array("name" => "invoice_date_due", "title" => "Date écheance"),
        5 => array("name" => "nature", "title" => "Nature Facture"),
        6 => array("name" => "total_ht", "title" => "Total HT"),
        7 => array("name" => "total_ttc", "title" => "Total TTC"),
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
                                        if($x>=5) break;
                                        
                                        } ?>
                                    </select>
                                </div>

                            </td>
                        </tr>
                    </table>

                </div>
                <!--                <div class="col-md-6">
                                    <table width="100%" class="">
                                        <tr>
                                            <td width="220">Afficher les Champs non utilisés</td>
                                            <td style="text-align: left">
                                                <div class="form-group form-md-line-input has-info">
                                                    <input type="checkbox" checked="checked">
                                                </div>
                
                                            </td>
                                        </tr>
                                    </table>
                
                                </div>-->
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
                                        <select class="form-control fields_import" <?php if (isset($field["list_values"])) { ?>list_values="<?php echo $field["list_values"]; ?>" <?php } ?> id="db_field_<?php echo $field["name"]; ?>">

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
            <button class="btn blue dropdown-toggle" data-toggle="dropdown">Mise à jours clients <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu ">

                <li>
                    <a  onclick="updateClientsValue('a')">
                        Tous</a>
                </li>
                <li>
                    <a  onclick="updateClientsValue('0')">
                        Non trouvés </a>
                </li>

            </ul>
        </div>


        <button class="btn green" onclick="verif_fields()">Vérification</button>
        <button class="btn" onclick="verif_and_import_fields()">Import</button>
    </div>
    <div class="clearfix"></div>

    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Liste des factures à importer</span>
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
                            echo '<select id="client_' . $row . '" style="width:150px;">';
                            ?>
                        <option value="0">Sélectionnez</option>
                        <?php
                        foreach ($clients as $client) {
                            ?>
                            <option value="<?php echo $client->client_id ?>"><?php echo $client->client_societe . ' (' . $client->client_name . ' ' . $client->client_prenom . ')' ?></option>
                            <?php
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
                $(this).removeClass("line_error");
                $("#check_" + line_value).css("display", "none");
                $("#client_" + line_value).css("display", "none");

            }
            else {
                $(this).removeClass('menu_selected');
                $("#check_" + line_value).css("display", "inherit");
                $("#client_" + line_value).css("display", "inherit");
            }
        });

    }

    function scrollToLog() {
        $('#scroll').scrollTop($('#scroll').prop('scrollHeight'));
        $("body").scrollTop($("body").prop('scrollHeight'));
    }

    function updateClientsValue(all) {
        var import_fields = {};
        var line_menu = $("#select_menu").val();
        var exist_field = 0;

        $(".table_import input[type=checkbox]").each(function () {

            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {

                if (all == "a" || $("#client_" + curr_line).val() == 0) {
                    import_fields[curr_line] = {};
                    $(".fields_import").each(function () {
                        var field_db_selected = $(this).val();

                        if (field_db_selected != "") {
                            var field_db = $(this).attr("id").substr(9);
                            if (field_db == "client_name") {
                                var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                                import_fields[curr_line][field_db] = value_db;
                                exist_field = 1;
                            }
                        }
                    });
                }
            }
        });


        if (exist_field == 1) {
            $.post("<?php echo site_url('import/ajax/updateClientsFactures'); ?>", {
                "import_fields": import_fields
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
                    var id_client = equiv[1];

                    if (id_client != 0) {
                        $("#client_" + id_line).val(id_client);
                        cnt++;
                    }
                });
                $("#console_log").parent().parent().show();
                $("#console_log").append("<span style=''>" + date_exec + " Mise à jour liste des clients ...</span> <br>");
                $("#console_log").append("<span class='log_success' style='margin-left:20px;'>" + cnt + " clients ont été mise à jour.</span> <br>");
                scrollToLog();
                $(".table_import input[type=checkbox]").each(function () {
                    var curr_line = $(this).attr("id").substr(6);
                    if (curr_line != line_menu) {
                        if ($("#client_" + curr_line).val() == 0 && $("#check_" + curr_line + ":checked").length > 0) {
                            $("#line_" + curr_line).addClass("line_error");
                        } else {
                            $("#line_" + curr_line).removeClass("line_error");
                        }
                    }
                });
            });
        }
        else {
            alert("Veuillez Selectionner le champ des clients");
        }

    }
    function verif_fields() {
        $("#console_log").parent().parent().show();

        var alert_final = "";
        var import_fields = {};
        var total_errors_count = "";
        var line_menu = $("#select_menu").val();
        $(".table_import input[type=checkbox]:checked").each(function () {
            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {
                import_fields[curr_line] = {};
                $(".fields_import").each(function () {
                    var field_db_selected = $(this).val();

                    if (field_db_selected != "") {

                        var field_db = $(this).attr("id").substr(9);
                        if (field_db == "client_name") {
                            import_fields[curr_line]["client_id"] = $("#client_" + curr_line).val();
                        }
                        else {
                            var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                            import_fields[curr_line][field_db] = value_db;
                        }
                    }
                });

            }
        });

        $.post("<?php echo site_url('import/ajax/verifFactures'); ?>", {
            "import_fields": import_fields
        }, function (data) {
//            alert(data);

            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            var date_exec = json_response[0];
            var errors_factures = json_response[1];
            var errors_fields = json_response[2];

            total_errors_count = errors_factures.length + errors_fields.length;

            $("#console_log").append("<span style=''>" + date_exec + " Verification des données (" + total_errors_count + " errors) ...</span> <br>");


            $(".fields_import").each(function () {
                $(this).removeClass("error_field");
            });

            var exist_error_lines = 0;
            $(".table_import input[type=checkbox]").each(function () {
                var curr_line = $(this).attr("id").substr(6);
                if (curr_line != line_menu) {
                    if ($("#client_" + curr_line).val() == 0 && $("#check_" + curr_line + ":checked").length > 0) {
                        $("#line_" + curr_line).addClass("line_error");
                        exist_error_lines = 1;
                    } else {
                        $("#line_" + curr_line).removeClass("line_error");
                    }
                }
            });


            $.each(errors_fields, function (key, value) {
                $(".fields_import").each(function () {
                    var field_db_selected = $(this).val();
                    var field_db = $(this).attr("id").substr(9);
                    if (field_db == value) {
                        $(this).addClass("error_field");
                        $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");

                    }
                });

            });
            $.each(errors_factures, function (key, value) {
                var val2 = value.split("_");
                exist_error_lines = 1;
                $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- La facture N° <a href='<?php echo base_url(); ?>invoices/view/" + val2[1] + "' target='_blank'>#" + val2[2] + "</a> qui se trouve dans la ligne " + val2[0] + " existe dejà.</span><br>");
                $("#line_" + val2[0]).addClass("line_error");


            });
            if (exist_error_lines == 1) {
                $("#console_log").append("<span style='cursor:pointer' class='log_success' onclick='ignoreLinesError()'>(Ignorer les lignes erronées)</span><br>");
            }
            scrollToLog();
        });

    }

    function ignoreLinesError() {

        $(".table_import .line_error").each(function () {
            var curr_line = $(this).attr("id").substr(5);
            $("#check_" + curr_line).prop("checked", false);
        });
    }

//    function import_fields() {
//        var msg_console = "<span style=''>Loading module import ...</span><br>";
//        $("#console_log").parent().parent().show();
//        $("#console_log").append(msg_console);
//
//
//        var x = 0;
//        if (x == 0) {
//            /// Insertion des clients
//
//            var import_fields = {};
//            var line_menu = $("#select_menu").val();
//            $(".table_import input[type=checkbox]:checked").each(function () {
//                var curr_line = $(this).attr("id").substr(6);
//                if (curr_line != line_menu) {
//                    import_fields[curr_line] = {};
//                    $(".fields_import").each(function () {
//                        var field_db_selected = $(this).val();
//
//                        if (field_db_selected != "") {
//                            var field_db = $(this).attr("id").substr(9);
//                            var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
//                            import_fields[curr_line][field_db] = value_db;
//                            if (field_db == "client_name") {
//                                import_fields[curr_line]["client_id"] = $("#client_" + curr_line).val();
//                            }
//                        }
//                    });
//
//                }
//            });
//
//            $.post("<?php // echo site_url('import/ajax/importFactures'); ?>", {
//                "import_fields": import_fields
//            }, function (data) {
//
//            });
//
//
//
//
//            messages_console = "<span style='margin-left:20px;' class='log_success'>Importation effectué avec succèes.</span><br>";
//        }
//        else {
//            messages_console = "<span style='margin-left:20px;' class='log_error'>Vous ne pouvez pas importer ce fichier. Veuillez corriger les erreurs.</span><br>";
//        }
//
//        $("#console_log").append(messages_console);
//        $("#console_log").append("<hr style='margin:5px 0;'>");
//        $('#scroll').scrollTop($('#scroll').prop('scrollHeight'));
//        $("body").scrollTop($("body").prop('scrollHeight'));
//
//
//
//    }


    function verif_and_import_fields() {
        $("#console_log").parent().parent().show();

        var alert_final = "";
        var import_fields = {};
        var total_errors_count = "";
        var line_menu = $("#select_menu").val();
        $(".table_import input[type=checkbox]:checked").each(function () {
            var curr_line = $(this).attr("id").substr(6);
            if (curr_line != line_menu) {
                import_fields[curr_line] = {};
                $(".fields_import").each(function () {
                    var field_db_selected = $(this).val();

                    if (field_db_selected != "") {

                        var field_db = $(this).attr("id").substr(9);
                        if (field_db == "client_name") {
                            import_fields[curr_line]["client_id"] = $("#client_" + curr_line).val();
                        }
                        else {
                            var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                            import_fields[curr_line][field_db] = value_db;
                        }
                    }
                });

            }
        });

        $.post("<?php echo site_url('import/ajax/verifFactures'); ?>", {
            "import_fields": import_fields
        }, function (data) {


            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            var date_exec = json_response[0];
            var errors_factures = json_response[1];
            var errors_fields = json_response[2];

            total_errors_count = errors_factures.length + errors_fields.length;

            $("#console_log").append("<span style=''>" + date_exec + " Verification des données (" + total_errors_count + " errors) ...</span> <br>");


            $(".fields_import").each(function () {
                $(this).removeClass("error_field");
            });

            var exist_error_lines = 0;
            $(".table_import input[type=checkbox]").each(function () {
                var curr_line = $(this).attr("id").substr(6);
                var line_menu = $("#select_menu").val();
                if (curr_line != line_menu) {
                    if ($("#client_" + curr_line).val() == 0 && $("#check_" + curr_line + ":checked").length > 0) {
                        $("#line_" + curr_line).addClass("line_error");
                        exist_error_lines = 1;
                    } else {
                        $("#line_" + curr_line).removeClass("line_error");
                    }
                }
            });

            var x = exist_error_lines + total_errors_count;
            if (x == 0) {
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
                                if (field_db == "client_name") {
                                    import_fields[curr_line]["client_id"] = $("#client_" + curr_line).val();
                                }
                            }
                        });

                    }
                });

                $.post("<?php echo site_url('import/ajax/importFactures'); ?>", {
                    "import_fields": import_fields,
                    "file_id": <?php echo $file_id; ?>
                }, function (data) {

                });




                messages_console = "<span style='margin-left:20px;' class='log_success'>Importation effectué avec succèes.</span><br>";
                $("#console_log").append(messages_console);
            } else {

                $.each(errors_fields, function (key, value) {
                    $(".fields_import").each(function () {
                        var field_db_selected = $(this).val();
                        var field_db = $(this).attr("id").substr(9);
                        if (field_db == value) {
                            $(this).addClass("error_field");
                            $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");

                        }
                    });

                });
                $.each(errors_factures, function (key, value) {
                    var val2 = value.split("_");
                    exist_error_lines = 1;
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- La facture N° <a href='<?php echo base_url(); ?>invoices/view/" + val2[1] + "' target='_blank'>#" + val2[2] + "</a> qui se trouve dans la ligne " + val2[0] + " existe dejà.</span><br>");
                    $("#line_" + val2[0]).addClass("line_error");


                });
                if (exist_error_lines == 1) {
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Veuillez selectionner les clients cochés.</span><br>");

                }
            }
            scrollToLog();



        });

    }

    $(function () {
        updatefieldsMenu();
        $("#select_menu").change(function () {
            updatefieldsMenu();
        });
    });
</script>