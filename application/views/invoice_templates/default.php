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
        $az = $convert[1] * 1;
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
    <title><?php echo lang('invoice') . " " . $invoice->invoice_number; ?> </title>
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
        <tr>
            <?php if ($typepdf == 0) {?>
            <td style=" width:300px ">
                <div id="logo"><img style="max-width:200px;max-height:100px;"
                        src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('invoice_logo')); ?>">
                </div>

            </td>
            <td style=" width:75px "></td>
            <td style=" width:325px; text-align:right; " colspan="2">
                <?php
$this->db->join('ip_societe_adresse', 'ip_societe_adresse.id_societe = ip_societes.id_societes', 'left');
    $societes = $this->db->get("ip_societes")->result();
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
            <?php } elseif ($typepdf == 1) {?>
            <td class="trpdf"></td>
            <?php }?>
        </tr>


        <tr>
            <td>
                <div id="devis_text" valign="top">
                    <img style=" width: 18%; margin-top:-25px"
                        src="<?php echo site_url('assets/default/img/logo_txt_fact.png'); ?>">

                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:325px ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo '&nbsp;' . $invoice->client_societe; ?></b><br>
                    <?php
if ($invoice->client_titre == 0) {
    $client_titre = "M.";
} elseif ($invoice->client_titre == 1) {
    $client_titre = "Mme.";
} elseif ($invoice->client_titre == 2) {
    $client_titre = "Mlle.";
}
//echo '<pre>';print_r($invoice);echo'</pre>';
?>
                    <i><?php echo '&nbsp;' . lang('attention_pdf') . ' ' . $client_titre . ' ' . $invoice->client_name . ' ' . $invoice->client_prenom . '<br/>'; ?></i>
                    <?php
if ($invoice->client_address_1) {
    echo $invoice->client_address_1 . ', ';
}
if ($invoice->client_address_2) {
    echo '&nbsp;' . $invoice->client_address_2 . ', ';
}
if ($invoice->client_zip) {
    echo '&nbsp;' . $invoice->client_zip . ' ';
}
if ($invoice->client_city) {
    echo '&nbsp;' . $invoice->client_city . ' ';
}
if ($invoice->client_state) {
    echo '&nbsp;' . $invoice->client_state;
}
if ($invoice->client_country) {
    echo '&nbsp;' . $countries[$invoice->client_country] . '<br/>';
}
if ($invoice->client_phone) {
    echo '&nbsp;' . lang('phone') . ': ' . $invoice->client_phone;
    if ($invoice->client_mobile) {
        echo " - " . $invoice->client_mobile;
    }
    echo '<br/>';
}
if ($invoice->client_tax_code) {
    echo '&nbsp;' . lang('registre_commerce_pdf') . ': ' . $invoice->client_tax_code;
    echo '<br/>';
}
if ($invoice->client_vat_id) {
    echo '&nbsp;' . lang('matricule_fisc_pdf') . ': ' . $invoice->client_vat_id . '<br/>';
}
?>
                </span></td>
            <td style=" width:100px "></td>

        </tr>



    </table>


    <br> <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo lang('num/ref') . '&nbsp;:&nbsp;' . lang('invoice'); ?>
        <?php echo $this->mdl_settings->setting('prefix_invoice') . $invoice->invoice_number; ?>
        <?php echo lang('quote_Du'); ?>
        <?php echo date_from_mysql($invoice->invoice_date_created, true); ?>
        <?php echo lang('quote_par'); ?>
        <?php
if ($invoice->user_code != '') {
    echo strtoupper($invoice->user_code);
} else {
    echo strtoupper($invoice->user_name);
}
?>
    </span>

    <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
        <b>
            <?php echo $invoice->nature; ?>
        </b>
    </p>
    <span style=" font-family: Arial, Arial; font-stretch: ultra-expanded; font-size: 12; color: #000">
        <?php
$dlai = '';
foreach ($delai as $value) {
    if ($value->delai_paiement_id == $invoice->invoice_delai_paiement) {
        $dlai = $value->delai_paiement_label;
    }

}
if ($dlai != '') {
    echo lang('CdtsReglement') . ': ';
    echo $dlai;
}
?>
        <br />
        <?php
if ($invoice->invoice_date_due != '0000-00-00') {
    echo lang('quote_expire_le') . ': ' . date_from_mysql($invoice->invoice_date_due, true);
}
?>
    </span>

    <?php
foreach ($devises as $value) {
    if ($invoice->client_devise_id == $value->devise_id) {
        $dev_lab = $value->devise_label;
        $dev_symb = $value->devise_symbole;
    }
}
$this->load->model('settings/mdl_settings');

foreach ($arrayItems as $itemsF) {
    if ($itemsF) {

        ?>
    <table class="table_products" style="width: 100%;margin-top:20px">
        <thead>
            <tr class="border-bottom-d tr_color">
                <th class="style_th" style="width: 100px;"><?php echo lang('item_pdf'); ?></th>
                <th class="style_th" style="width: 250px;">
                    <?php echo lang('description'); ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
        if ($setting == 1) {
            ?>
                <th style=" text-align: center;" class="style_th"><?php echo lang('qte_pdf'); ?></th>
                <th style=" text-align: center;" class="style_th"><?php echo lang('price_pdf'); ?></th>
                <?php } else {?>
                <th style=" text-align: center;" class="style_th"> Quantité </th>
                <th style=" text-align: center;" class="style_th">PU (DT)</th>
                <?php }?>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
        if ($setting == 1) {
            ?>
                <th style=" text-align: center;" class="style_th"><?php echo lang('tva_pdf'); ?></th>
                <?php }?>
                <th style=" text-align: center;" class="style_th"><?php echo lang('total_pdf'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
$linecounter = 0;

        foreach ($itemsF as $item) {
            ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_name; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo (int) $item->item_quantity; ?></td>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php echo format_devise($item->item_price, $invoice->client_devise_id); ?></td>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
            if ($setting == 1) {
                ?>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php echo format_amount($item->tax_rate_percent); ?></td>
                <?php }?>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php echo format_devise($item->item_total, $invoice->client_devise_id); ?></td>
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
                <?php echo lang('bon_accord_pdf'); ?>
                <div style="margin-top:100px;font-size:10px"><?php echo lang('signature_pdf'); ?></div>
            </div>
            <?php
//echo strcmp($dlai, '');
if ((strcmp($dlai, '') != 0)) {
    ?>
            <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 11px; color: #000">
                <?php echo lang('quote_delai_paiement') . ' : ' . $dlai; ?>
            </span>
            <?php }?>
        </div>
        <div style="float:right">
            <table>
                <tr>
                    <td class="text-right">
                        <table class="" style="width: 250px; font-size:12px;">
                            <?php if ($invoice->invoice_pourcent_remise != 0) {?>
                            <tr>
                                <th class="text-right" style="width: 150px; padding:5px; color:#000000;">
                                    <?php echo lang('remise_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_remise;
    echo $rem;
    ?> %</th>
                                <th class="text-right td_backgrounded" style="border:#5e5e5e solid 1px; padding:5px;">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_remise, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php }?>
                        </table>

                        <table class="tables_calculs" border="0" cellpadding="0" cellspacing="0" style="width: 250px">
                            <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                            <tr>
                                <th class="td_backgrounded" style="width: 150px;"><?php echo lang('total_pdf'); ?>
                                    <?php echo $dev_symb; ?> <?php echo lang('ht_pdf'); ?>:</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <tr>
                                <td class=""><b><?php echo lang('total_pdf'); ?> <?php echo $dev_symb; ?>
                                        <?php echo lang('tva_pdf2'); ?>:</b></td>
                                <td class="text-right"><b>
                                        <?php echo format_devise($invoice->invoice_item_tax_total, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                            </tr>
                            <?php } else {?>
                            <tr>
                                <th class="td_backgrounded" style="width: 150px;">
                                    Total (DT):</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>

                            <?php }?>
                            <?php if ($invoice->timbre_fiscale != 0) {?>

                            <tr>
                                <td class=""><b><?php echo lang('timbre_pdf'); ?> </b></td>
                                <td class="text-right "><b>
                                        <?php echo format_devise($invoice->timbre_fiscale, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                            </tr>

                            <?php }?>
                            <tr style=" display: none" class="amount-total border-top-n">
                                <td class="td_backgrounded"><b><?php echo lang('total_pdf'); ?> <?php echo $dev_symb; ?>
                                        <?php echo lang('ttc'); ?>:</b></td>
                                <td class="text-right color-d td_backgrounded">
                                    <b><?php echo format_devise($invoice->invoice_total, $invoice->client_devise_id, 0); ?></b>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                        <table class="tables_calculs" border="1" style=" width: 250px">
                            <?php /* if ($invoice->invoice_paid > 0) { ?>
                            <tr>
                                <th class="td_backgrounded" style="width: 150px;"><?php echo lang('paye_pdf'); ?>
                                    <!--(<?php echo $invoice->quote_pourcent_acompte; ?>%)-->
                                </th>
                                <th class="text-right td_backgrounded">
                                    <?php echo '-' . format_currency_without_symbol($invoice->invoice_paid, $dev_symb); ?>
                                </th>
                            </tr>
                            <?php } */?>


                            <?php if ($invoice->invoice_pourcent_acompte != 0) {?>

                            <tr>
                                <th class="td_backgrounded"><?php echo lang('acompte_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_acompte;
        echo $rem;
        ?> %</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_acompte, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="td_backgrounded">Reste à payer</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php } else {?>
                            <tr>
                                <th class="td_backgrounded">Net à payer</th>
                                <th class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
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
                <?php echo lang('msg_arret_fact'); ?><br>
                <?php
//echo
$rest = int2str($invoice->invoice_balance, $dev_symb);

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
            <?php
if (trim($invoice->invoice_terms) != "") {?>
            <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . $invoice->invoice_terms; ?></p>
            <?php }?>

        </div>
        <div style="clear:both"></div>
        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000"
            class="text-right"><?php echo lang('msg_merci'); ?></p>
    </div>

</body>

</html>