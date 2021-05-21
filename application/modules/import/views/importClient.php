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
        0 => array("name" => "client_name", "title" => "Nom"),
        1 => array("name" => "client_prenom", "title" => "Prénom"),
        2 => array("name" => "client_societe", "title" => "Société"),
        3 => array("name" => "client_titre", "title" => "Civ", "list_values" => "M.|Mme.|Melle"),
        4 => array("name" => "client_address_1", "title" => "Adresse 1"),
        5 => array("name" => "client_address_2", "title" => "Adresse 2"),
        6 => array("name" => "client_state", "title" => "Ville"),
        7 => array("name" => "client_zip", "title" => "Code postal"),
        8 => array("name" => "client_country", "title" => "Pays"),
        9 => array("name" => "client_phone", "title" => "Téléphone"),
        10 => array("name" => "client_fax", "title" => "Fax"),
        11 => array("name" => "client_mobile", "title" => "Portable"),
        12 => array("name" => "client_email", "title" => "Email"),
        13 => array("name" => "client_web", "title" => "Site Web"),
        14 => array("name" => "client_vat_id", "title" => "Matricule fiscal"),
        15 => array("name" => "client_tax_code", "title" => "Registre de commerce"),
        16 => array("name" => "client_type", "title" => "Type Client", "list_values" => "Prospect|Client", "required" => 0),
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
        <button class="btn green" onclick="verif_fields()">Vérification</button>
        <button class="btn" onclick="verifAndImport()">Import</button>
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
                            echo '<select id="devise_' . $row . '" style="width:150px;">';
                            ?>
                            <?php
                            foreach ($devises as $devise) {
                                ?>
                            <option value="<?php echo $devise->devise_id ?>"><?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?></option>
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
                $("#devise_" + line_value).css("display", "none");
            }
            else {
                $(this).removeClass('menu_selected');
                $("#check_" + line_value).css("display", "inherit");
                $("#devise_" + line_value).css("display", "inherit");
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
        $.post("<?php echo site_url('import/ajax/verifClients'); ?>", {
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
            var errors_cons = json_response[0];
            var errors_cons2 = json_response[1];
            var date_exec = json_response[2];


            total_errors_count = errors_cons.length + errors_cons2.length;
            $("#console_log").append("<span style=''>" + date_exec + " Vérification du fichier à importer ...</span> (" + total_errors_count + " erreurs)<br>");
            $.each(errors_cons, function (key, value) {
                $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");
            });
            
            $.each(errors_cons2, function (key, value) {
                var val2 = value.split("_");
                $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le client #" + val2[1] + " à importer existe déja. il est equivalent au client <a href='<?php echo base_url(); ?>clients/view/" + val2[0] + "' target='_blank'>#" + val2[0] + "</a> . </span><br>");
                $("#line_" + val2[1]).addClass("line_error");

            });

            $("#console_log").append("<hr style='margin:5px 0;'>");
            scrollToLog();
        });



    }

    function import_fields() {
        var msg_console = "<span style=''>Loading module import ...</span><br>";
        $("#console_log").parent().parent().show();
        $("#console_log").append(msg_console);
        var x = 0;
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
                        }
                    });
                }
            });

            $.post("<?php echo site_url('import/ajax/importClients'); ?>", {
                "import_fields": import_fields
            }, function (data) {

                alert(data);
            });

            messages_console = "<span style='margin-left:20px;' class='log_success'>Importation effectué avec succèes.</span><br>";
        }
        else {
            messages_console = "<span style='margin-left:20px;' class='log_error'>Vous ne pouvez pas importer ce fichier. Veuillez corriger les erreurs.</span><br>";
        }

        $("#console_log").append(messages_console);
        $("#console_log").append("<hr style='margin:5px 0;'>");
        $('#scroll').scrollTop($('#scroll').prop('scrollHeight'));
        $("body").scrollTop($("body").prop('scrollHeight'));



    }

    function convert_pays(pays) {
        if (pays.length == 2) {
            return pays;
        }
        else
        if (pays.length == 3) {
            if (pays.toLowerCase() == 'fra') {
                return 'FR';
            }
            else
                return 'TN';

        }
        else {
            return 'TN';
        }

    }


    function verifAndImport() {
        var msg_console = "<span style=''>Loading module import ...</span><br>";
        $("#console_log").parent().parent().show();
        $("#console_log").append(msg_console);

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
                        var value_db = $("#num_" + curr_line + "_" + field_db_selected).val();
                        if (field_db == "client_country") {
                            value_db = convert_pays(value_db);
                        }
                        import_fields[curr_line][field_db] = value_db;
                    }
                });
                import_fields[curr_line]["client_devise_id"] = $("#devise_" + curr_line).val();

            }
        });
        $.post("<?php echo site_url('import/ajax/verifClients'); ?>", {
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
            var errors_cons = json_response[0];
            var errors_cons2 = json_response[1];
            var date_exec = json_response[2];


            total_errors_count = errors_cons.length + errors_cons2.length;

            if (total_errors_count == 0) {
                /// Insertion des clients



                $.post("<?php echo site_url('import/ajax/importClients'); ?>", {
                    "import_fields": import_fields,
                    "file_id": <?php echo $file_id; ?>
                }, function (data) {

//                    alert(data);
                });

                messages_console = "<span style='margin-left:20px;' class='log_success'>Importation effectué avec succèes.</span><br>";
            }
            else {

                $("#console_log").append("<span style=''>" + date_exec + " Vérification du fichier à importer ...</span> (" + total_errors_count + " erreurs)<br>");
                $.each(errors_cons, function (key, value) {
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le champ " + value + " est obligatoire.</span><br>");
                });
                $.each(errors_cons2, function (key, value) {
                    var val2 = value.split("_");
                    $("#console_log").append("<span style='margin-left:20px;' class='log_error'>- Le client #" + val2[1] + " à importer existe déja. il est equivalent au client <a href='<?php echo base_url(); ?>clients/view/" + val2[0] + "' target='_blank'>#" + val2[0] + "</a> . </span><br>");
                    $("#line_" + val2[1]).addClass("line_error");

                });

                $("#console_log").append("<hr style='margin:5px 0;'>");
                scrollToLog();
                
                messages_console = "<span style='margin-left:20px;' class='log_error'>Vous ne pouvez pas importer ce fichier. Veuillez corriger les erreurs.</span><br>";


            }
            $("#console_log").append(messages_console);

        });


    }


    $(function () {
        updatefieldsMenu();
        $("#select_menu").change(function () {
            updatefieldsMenu();
        });
    });
</script>