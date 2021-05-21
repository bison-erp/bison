<style>
.trpdf {
    padding: 60px 10px
}
</style>
<?php

function int2str($a, $symbole)
{
    $convert = explode('.', $a);
    if (isset($convert[1]) && $convert[1] != '') {
        $az = $convert[1];
        return int2str($convert[0], $symbole) . ' ' . $symbole . ' et ' . int2str($az, $symbole);
    }
    if ($a < 0) {
        return 'moins ' . int2str(-$a, $symbole);
    }

    if ($a < 17) {
        switch ($a) {
            case 0:return 'zero';
            case 1:return 'un';
            case 2:return 'deux';
            case 3:return 'trois';
            case 4:return 'quatre';
            case 5:return 'cinq';
            case 6:return 'six';
            case 7:return 'sept';
            case 8:return 'huit';
            case 9:return 'neuf';
            case 10:return 'dix';
            case 11:return 'onze';
            case 12:return 'douze';
            case 13:return 'treize';
            case 14:return 'quatorze';
            case 15:return 'quinze';
            case 16:return 'seize';
        }
    } else if ($a < 20) {
        return 'dix-' . int2str($a - 10, $symbole);
    } else if ($a < 100) {
        if ($a % 10 == 0) {
            switch ($a) {
                case 20:return 'vingt';
                case 30:return 'trente';
                case 40:return 'quarante';
                case 50:return 'cinquante';
                case 60:return 'soixante';
                case 70:return 'soixante-dix';
                case 80:return 'quatre-vingt';
                case 90:return 'quatre-vingt-dix';
            }
        } else if ($a < 70) {
            return int2str(($a - $a % 10), $symbole) . '-' . int2str(($a % 10), $symbole);
        } else if ($a < 80) {
            return int2str(60, $symbole) . '-' . int2str(($a % 20), $symbole);
        } else {
            return int2str(80, $symbole) . '-' . int2str(($a % 20), $symbole);
        }
    } else if ($a == 100) {
        return 'cent';
    } else if ($a < 200) {
        return int2str(100, $symbole) . ($a % 100 != 0 ? ' ' . int2str(($a % 100), $symbole) : '');
    } else if ($a < 1000) {
        return int2str(((int) ($a / 100)), $symbole) . ' ' . int2str(100, $symbole) . ' ' . ($a % 100 != 0 ? int2str(($a % 100), $symbole) : '');
    } else if ($a == 1000) {
        return 'mille';
    } else if ($a < 2000) {
        return int2str(1000, $symbole) . ($a % 1000 != 0 ? ' ' . int2str(($a % 1000), $symbole) : '');
    } else if ($a < 1000000) {
        return int2str(((int) ($a / 1000)), $symbole) . ' ' . int2str(1000, $symbole) . ' ' . ($a % 1000 != 0 ? int2str(($a % 1000), $symbole) : '');
    } else {
        return $a;
    }

}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/custom.css">

    <style>
    .table_products tr th {
        background: #e2e2e2;
        /* for non-css3 browsers */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fbfbfb',
            endColorstr='#e2e2e2');
        /* for IE */
        background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb),
            to(#e2e2e2));
        /* for webkit browsers */
        background: -moz-linear-gradient(top, #fbfbfb, #e2e2e2);
        /* for firefox 3.6+
                */
        border: #5e5e5e solid 1px;
        border-bottom: #999 solid 2px;
        color: #000000;
        font-size: 11px;
        font-family: arial;
        padding: 0.2em 0.4em 0.4em;
    }

    .td_backgrounded {
        background: #e2e2e2;
        /* for non-css3 browsers */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fbfbfb',
            endColorstr='#e2e2e2');
        /* for IE */
        background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb),
            to(#e2e2e2));
        /* for webkit browsers */
        background: -moz-linear-gradient(top, #fbfbfb, #e2e2e2);
        /* for firefox 3.6+
                */

        border-bottom: #5e5e5e solid 1px;
        color: #000000;
        font-size: 11px;
        font-family: arial;

    }

    .table_products,
    .tables_calculs {

        border: #5e5e5e solid 1px;
        margin-bottom: 20px;
    }

    .table_products tr td,
    .tables_calculs tr td {
        border: #5e5e5e solid 1px;
        color: #000000;
        font-size: 12px;
        padding: 5px;
    }

    .tables_calculs tr th {
        border: #5e5e5e solid 1px;
        color: #000000;
        font-size: 12px;
        padding: 5px;
    }
    </style>

</head>

<body style="">
    <table style=" width: 100%">
        <?php
if ($typepdf == 0) {
    ?>
        <tr>
            <td style=" width:300px ">
                <div id="logo"><img style="max-width:200px;max-height:100px;"
                        src="<?php echo base_url('uploads/' . strtolower($licence) . '/' . $settval); ?>">
                </div>
            </td>
            <td style=" width:75px "></td>
            <td style=" width:325px; text-align:right; " colspan="2">
                <?php
$this->db->join($db . '.ip_societe_adresse', 'ip_societe_adresse.id_societe = ip_societes.id_societes', 'left');
    $societes = $this->db->get($db . ".ip_societes")->result();
    $societe_name = $societes[0]->raison_social_societes;
    $societe_tel = $societes[0]->telephone;
    $societe_mail = $societes[0]->mail_societes;
//                    print_r($societes[0]);
    ?>
                <b>
                    <?php echo $societe_name; ?>
                    <!--Novatis SUARL-->
                </b>
                <?php if ($societe_tel != '') {?>
                <br>
                Tél : <?php echo $societe_tel; ?>
                <!--Tél : 70 737 903 / 71 949 154-->
                <?php }?>
                <?php if ($societe_mail != '') {?>
                <br>
                Email : <?php echo $societe_mail; ?>
                <!--Email: commercial@novatis.tn-->
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>
                <div id="devis_text" valign="top">
                    <img style=" width: 18%; margin-top:-25px"
                        src="<?php echo site_url('assets/default/img/logo_novatis_text.jpg'); ?>">
                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $quote->client_societe; ?></b><br>
                    <?php
if ($quote->client_titre == 0) {
        $client_titre = "M.";
    } elseif ($quote->client_titre == 1) {
        $client_titre = "Mme.";
    } elseif ($quote->client_titre == 2) {
        $client_titre = "Mlle.";
    }
    ?>

                    <?php echo $lang['attention_pdf'] . ' ' . $client_titre . ' ' . $quote->client_name . ' ' . $quote->client_prenom . '<br/>'; ?>


                    <?php
if ($quote->client_address_1) {
        echo $quote->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_address_2) {
        echo $quote->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_zip) {
        echo $quote->client_zip . ' ';
    }
    ?>
                    <?php
if ($quote->client_city) {
        echo $quote->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($quote->client_state) {
        echo $quote->client_state . '&nbsp;';
    }
    if ($quote->client_country) {
        echo $countries[$quote->client_country] . '<br/>';
    }
    if ($quote->client_phone) {
        echo $lang['phone'] . ': ' . $quote->client_phone;
        if ($quote->client_mobile) {
            echo " - " . $quote->client_mobile;
        }
        echo '<br/>';
    }
    ?>

                    <?php
if ($quote->client_tax_code) {
        echo $lang['registre_commerce_pdf'] . ': ' . $quote->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_mat_fiscal) {
        echo $lang['matricule_fisc_pdf'] . ': ' . $quote->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>
            <td style=" width:10px ">
            </td>
        </tr>
        <?php
} elseif ($typepdf == 1) {?>
        <tr>
            <td class="trpdf"></td>
        </tr>
        <tr>
            <td>

                <div id="devis_text" valign="top">
                    <img style="margin-left: 0px; width: 18%; margin-top:-25px"
                        src="<?php echo site_url('assets/default/img/logo_novatis_text.jpg'); ?>">
                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $quote->client_societe; ?></b><br>
                    <?php
if ($quote->client_titre == 0) {
    $client_titre = "M.";
} elseif ($quote->client_titre == 1) {
    $client_titre = "Mme.";
} elseif ($quote->client_titre == 2) {
    $client_titre = "Mlle.";
}
    ?>

                    <?php echo $lang['attention_pdf'] . ' ' . $client_titre . ' ' . $quote->client_name . ' ' . $quote->client_prenom . '<br/>'; ?>


                    <?php
if ($quote->client_address_1) {
        echo $quote->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_address_2) {
        echo $quote->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_zip) {
        echo $quote->client_zip . ' ';
    }
    ?>
                    <?php
if ($quote->client_city) {
        echo $quote->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($quote->client_state) {
        echo $quote->client_state . '&nbsp;';
    }
    if ($quote->client_country) {
        echo $countries[$quote->client_country] . '<br/>';
    }
    if ($quote->client_phone) {
        echo $lang['phone'] . ': ' . $quote->client_phone;
        if ($quote->client_mobile) {
            echo " - " . $quote->client_mobile;
        }
        echo '<br/>';
    }
    ?>

                    <?php
if ($quote->client_tax_code) {
        echo $lang['registre_commerce_pdf'] . ': ' . $quote->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($quote->client_mat_fiscal) {
        echo $lang['matricule_fisc_pdf'] . ': ' . $quote->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>

            </td>
        </tr>

        <?php
}
?>
    </table>

    <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo $lang['quote_Devis']; ?>
        <?php echo $this->mdl_settings->setting('prefix_quote') . $quote->quote_number; ?>
        <?php echo $lang['quote_Du']; ?>
        <?php echo date_from_mysql($quote->quote_date_created, true); ?>
        <?php echo $lang['quote_par']; ?>
        <?php
if ($quote->user_code != '') {
    echo $quote->user_code;
} else {
    echo $quote->user_name;
}
?>
    </span>
    <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
        <b>
            <?php echo $quote->quote_nature; ?>
        </b>
    </p>
    <span style=" font-family: Arial, Arial; font-stretch: ultra-expanded; font-size: 12; color: #000">
        <?php
if ($quote->quote_date_expires != '0000-00-00') {
    echo '&nbsp;&nbsp;' . $lang['quote_expire_le'];
    ?> : <?php
echo date_from_mysql($quote->quote_date_expires, true);
}
?>
    </span>
    <?php
foreach ($devises as $value) {
    if ($quote->client_devise_id == $value->devise_id) {
        $dev_lab = $value->devise_label;
        $dev_symb = $value->devise_symbole;
    }
}
?>
    <?php
//$this->load->model('settings/mdl_settings');

foreach ($arrayItems as $itemsF) {
    if ($itemsF) {
        ?>
    <table class="table_products" style="width: 100%;margin-top:20px">
        <thead>
            <tr class="border-bottom-d tr_color">
                <th class="style_th" style="width: 80px;"><?php echo $lang['item_pdf']; ?></th>
                <th class="style_th" style="width: 350px;">
                    <?php echo $lang['description']; ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
                <?php
if ($setting == 1) {
            ?>
                <th style=" text-align: center;" class="style_th"><?php echo $lang['qte_pdf']; ?></th>
                <th style=" text-align: center;width: 120px" class="style_th"><?php echo $lang['price_pdf']; ?></th>
                <?php } else {?>
                <th style=" text-align: center;" class="style_th"><?php echo $lang['tva_pdf']; ?></th>
                <th style=" text-align: center;width: 120px" class="style_th"><?php echo $lang['total_pdf']; ?></th>
                <?php }?>
                <?php
if ($setting == 1) {
            ?>
                <th style=" text-align: center;" class="style_th"><?php echo $lang['tva_pdf']; ?></th>
                <?php }?>
                <th style=" text-align: center;width: 120px;" class="style_th"><?php echo $lang['total_pdf']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
function formatdevisere($db, $amount, $devise_id, $display_symbol = 1)
        {
            $CI = get_instance();
            $amount = (float) $amount;
            $CI->db->where("devise_id", $devise_id);
            $devise = $CI->db->get($db . '.ip_devises')->result();

            if (!empty($devise)) {
                $devise_symbole = $devise[0]->devise_symbole;
                $symbole_placement = $devise[0]->symbole_placement;
                $number_decimal = (int) $devise[0]->number_decimal;
                $thousands_separator = $devise[0]->thousands_separator;

                $export = number_format($amount, $number_decimal, '.', $thousands_separator);
                if ($display_symbol == 1) {
                    if ($symbole_placement == "before") {
                        return $devise_symbole . ' ' . $export;
                    } else {
                        return $export . ' ' . $devise_symbole;
                    }
                } else {
                    return $export;
                }
            } else {
                return $amount;
            }
        }
        $linecounter = 0;
        foreach ($itemsF as $item) {
            ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo (int) $item->item_quantity; ?></td>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php
echo formatdevisere($db, $item->item_price, $quote->client_devise_id); ?></td>
                <?php
if ($setting == 1) {
                ?>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php
echo number_format($item->tax_rate_percent, 3, '.', '');
                //   echo formatamountre($db, $item->tax_rate_percent);
                 ?></td>

                <?php }?>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php echo formatdevisere($db, $item->item_total, $quote->client_devise_id); ?></td>
            </tr>
            <?php $linecounter++;?>
            <?php }?>
        </tbody>
    </table>
    <?php
}
}
?>
    <div>
        <!--zone de droite-->
        <div style="font-family: Arial; width:40%;color:#000;float:left; margin-top: 0px">
            <div style="font-family: Arial; border:1px solid #000;font-size:10px; padding:10px">
                <?php echo $lang['bon_accord_pdf']; ?>
                <div style="margin-top:100px;font-size:10px"><?php echo $lang['signature_pdf']; ?></div>
            </div>

        </div>
        <div style="float:right">
            <table>
                <tr>
                    <td class="text-right">
                        <table class="" style="width: 250px; font-size:12px;">
                            <?php if ($quote->quote_pourcent_remise != 0) {?>
                            <tr>
                                <th class="text-right" style="width: 150px; padding:5px; color:#000000;">
                                    <?php echo $lang['remise_pdf']; ?> <?php
$rem = (float) $quote->quote_pourcent_remise;
    echo $rem;
    ?> %</th>
                                <th class="text-right td_backgrounded" style="border:#5e5e5e solid 1px; padding:5px;">
                                    <?php echo '-' . formatdevisere($db, $quote->quote_montant_remise, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php }?>
                        </table>

                        <table class="tables_calculs" border="0" cellpadding="0" cellspacing="0" style="width: 250px">
                            <?php //$setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                            <tr>
                                <th class="td_backgrounded" style="width: 150px;"><?php echo $lang['total_pdf']; ?>
                                    <?php echo $dev_symb; ?> <?php echo $lang['ht_pdf']; ?>:</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo formatdevisere($db, $quote->quote_item_subtotal, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <tr>
                                <td class=""><?php echo $lang['total_pdf']; ?> <?php echo $dev_symb; ?>
                                    <?php echo $lang['tva_pdf2']; ?>:</td>
                                <td class="text-right">
                                    <?php echo formatdevisere($db, $quote->quote_item_tax_total, $quote->client_devise_id, 0); ?>
                                </td>
                            </tr>
                            <?php } else {?>

                            <tr>
                                <th class="td_backgrounded" style="width: 150px;">
                                    Total (DT):</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo formatdevisere($db, $quote->quote_item_subtotal, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>

                            <?php }?>

                            <?php if ($quote->timbre_fiscale != 0) {?>

                            <tr>
                                <td class=""><?php echo $lang['timbre_pdf']; ?></td>
                                <td class="text-right ">
                                    <?php echo formatdevisere($db, $quote->timbre_fiscale, $quote->client_devise_id, 0); ?>
                                </td>
                            </tr>

                            <?php }?>
                            <tr style=" display: none" class="amount-total border-top-n">
                                <td class="td_backgrounded"><b><?php echo $lang['total_pdf']; ?>
                                        <?php echo $dev_symb; ?>
                                        <?php echo $lang['ttc']; ?>:</b></td>
                                <td class="text-right color-d td_backgrounded">
                                    <b><?php echo formatdevisere($db, $quote->quote_total, $quote->client_devise_id, 0); ?></b>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <?php //$setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                        <table class="tables_calculs" border="1" style=" width: 250px">

                            <?php if ($quote->quote_pourcent_acompte != 0) {?>

                            <tr>
                                <th class="td_backgrounded"><?php echo $lang['acompte_pdf']; ?> <?php
$rem = (float) $quote->quote_pourcent_acompte;
        echo $rem;
        ?> %</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo '-' . formatdevisere($db, $quote->quote_montant_acompte, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="td_backgrounded">Reste à payer</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo formatdevisere($db, $quote->quote_total_a_payer, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php } else {?>


                            <tr>
                                <th class="td_backgrounded">Net à payer</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo formatdevisere($db, $quote->quote_total_a_payer, $quote->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php }?>
                        </table>
                        <?php } else {?>
                        <table>
                            <tr>
                                <td height="50"></td>
                            </tr>
                        </table>
                        <?php }?>
                    </td>
                </tr>
            </table>
        </div>


        <!--remarque de gauche-->

        <div style="width:50%;float:left;">

            <p class=""
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo $lang['msg_arret']; ?>
                <?php
//echo
$rest = int2str($quote->quote_total_a_payer, $dev_symb);

$pos1 = stripos($rest, 'DT');
if ($pos1 != '') {
    $res1 = str_replace('DT', ' Dinars ', $rest);
    echo $res1 . ' Millimes';
}
$pos2 = stripos($rest, '$');
if ($pos2 != '') {
    $res2 = str_replace('$', ' Dollars ', $rest);
    echo $res2 . ' Cents';
}
$pos3 = stripos($rest, '€');
if ($pos3 != '') {
    $res3 = str_replace('€', ' Euros ', $rest);
    echo $res3 . ' Centimes';
}
?></p>

            <?php if (trim($quote->notes) != "") {?>
            <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . $lang['notes'] . ":</b> " . $quote->notes; ?></p>
            <?php }?>
        </div>

        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000"
            class="text-right"><?php echo $lang['msg_merci']; ?></p>
    </div>
</body>

</html>