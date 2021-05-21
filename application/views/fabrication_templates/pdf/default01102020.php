<style>
.trpdf {
    padding: 60px 10px
}
</style> 
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
<?php if($fabrication->langue!='Arabic'){ 
      $this->lang->load('ip_', $fabrication->langue);
      
      $this->load->helper('language');
    
     $this->load->module('layout');
    ?>

<body style="">
    <table style=" width: 100%">
        <?php
      
if ($typepdf == 0) {
    ?>
        <tr>
            <td style=" width:325px; text-align:left; " colspan="2">
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
            <td style=" width:75px "></td>
            <td style=" width:300px ;text-align:right">
                <div id="logo">
                    <?php $output = "./uploads/";
    $output .= strtolower($this->session->userdata('licence'));
    $output .= "/";
    $output .= $this->mdl_settings->setting('invoice_logo');
    ?>
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">

                </div>
            </td>
        </tr> 
        <tr>
            <td style="height:50px" >
            </td>
         </tr>           
        <tr>
           
            <td valign="bottom" style=" width:315px ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $fabrication->client_societe; ?></b><br>
                    <?php
if ($fabrication->client_titre == 0) {
        $client_titre = "M.";
    } elseif ($fabrication->client_titre == 1) {
        $client_titre = "Mme.";
    } elseif ($fabrication->client_titre == 2) {
        $client_titre = "Mlle.";
    }
    ?>

                    <?php echo lang('attention_pdf') . ' ' . $client_titre . ' ' . $fabrication->client_name . ' ' . $fabrication->client_prenom . '<br/>'; ?>


                    <?php
if ($fabrication->client_address_1) {
        echo $fabrication->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_address_2) {
        echo $fabrication->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_zip) {
        echo $fabrication->client_zip . ' ';
    }
    ?>
                    <?php
if ($fabrication->client_city) {
        echo $fabrication->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($fabrication->client_state) {
        echo $fabrication->client_state . '&nbsp;';
    }
    if ($fabrication->client_country) {
        echo $countries[$fabrication->client_country] . '<br/>';
    }
    if ($fabrication->client_phone) {
        echo lang('phone') . ': ' . $fabrication->client_phone;
        if ($fabrication->client_mobile) {
            echo " - " . $fabrication->client_mobile;
        }
        echo '<br/>';
    }
    ?>

                    <?php
if ($fabrication->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $fabrication->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $fabrication->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>
                <td style=" width:75px "></td>
                <td colspan="2" style="text-align:right">
                <div id="devis_text" valign="top">
                    <?php 
                    $output ="";
                    if($fabrication->langue=="English"){
                        $output = "./assets/default/img/logo_txt_fabrication-en.jpg";
                    }else{
                        $output = "./assets/default/img/logo_txt_fabrication.jpg";
                    }
    ?>
                    <img style=" width: 18%; margin-top:35px" src="<?php echo $output; ?>">

                </div>
            </td>
          

            <td style=" width:10px ">
            </td>
        </tr>
        <?php
} elseif ($typepdf == 1) {?>
        <tr>
            <td class="trpdf"></td>
        </tr>
        <tr>
            <td valign="bottom" style=" width:315px ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $fabrication->client_societe; ?></b><br>
                    <?php
if ($fabrication->client_titre == 0) {
        $client_titre = "M.";
    } elseif ($fabrication->client_titre == 1) {
        $client_titre = "Mme.";
    } elseif ($fabrication->client_titre == 2) {
        $client_titre = "Mlle.";
    }
    ?>

                    <?php echo lang('attention_pdf') . ' ' . $client_titre . ' ' . $fabrication->client_name . ' ' . $fabrication->client_prenom . '<br/>'; ?>


                    <?php
if ($fabrication->client_address_1) {
        echo $fabrication->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_address_2) {
        echo $fabrication->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_zip) {
        echo $fabrication->client_zip . ' ';
    }
    ?>
                    <?php
if ($fabrication->client_city) {
        echo $fabrication->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($fabrication->client_state) {
        echo $fabrication->client_state . '&nbsp;';
    }
    if ($fabrication->client_country) {
        echo $countries[$fabrication->client_country] . '<br/>';
    }
    if ($fabrication->client_phone) {
        echo lang('phone') . ': ' . $fabrication->client_phone;
        if ($fabrication->client_mobile) {
            echo " - " . $fabrication->client_mobile;
        }
        echo '<br/>';
    }
    ?>

                    <?php
if ($fabrication->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $fabrication->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $fabrication->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>

            </td>
            <td style=" width:75px "></td>
            <td style="text-align:right">

<div id="devis_text" valign="top">
    <!--<img style="margin-left: 0px; width: 18%; margin-top:-25px"
        src="<?php echo site_url('assets/default/img/logo_txt_fabrication.jpg'); ?>">
        --><?php
         $output ="";
         if($fabrication->langue=="English"){
             $output = "./assets/default/img/logo_txt_fabrication-en.jpg";
         }else{
             $output = "./assets/default/img/logo_txt_fabrication.jpg";
         }                       
?>
    <img style=" width: 18%; margin-top: 35px" src="<?php echo $output; ?>">
</div>
</td>
        </tr>

        <?php
}
?>
    </table>
    <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
        <b>
            <?php echo $fabrication->fabrication_nature; ?>
        </b>
    </p>
   
    <table>
    <tr>
    <td style="text-align:left;">
    <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo lang('bf'); ?> N°
        <?php echo $this->mdl_settings->setting('prefix_fabrication') . $fabrication->fabrication_number; ?>
        <?php echo lang('quote_Du'); ?>
        <?php echo date_from_mysql($fabrication->quote_date_created, true); ?>
        <?php echo lang('quote_par'); ?>
        <?php
if ($fabrication->user_code != '') {
    echo $fabrication->user_code;
} else {
    echo $fabrication->user_name;
}
?>
    </span>
    </td>
    <td style="text-align:right;">
    <span style="  font-family: Arial, Arial; font-stretch: ultra-expanded; font-size: 12; color: #000">
        <?php
if ($fabrication->quote_date_expires != '0000-00-00') {
    echo '&nbsp;&nbsp;' . lang('quote_expire_le');
    ?> : <?php
echo date_from_mysql($fabrication->quote_date_expires, true);
}
?>

    </span>
    </td>
    </tr>
    </table>
   
    
    <?php
foreach ($devises as $value) {
    if ($fabrication->client_devise_id == $value->devise_id) {
        $dev_lab = $value->devise_label;
        $dev_symb = $value->devise_symbole;
    }
}
?>
    <?php
$this->load->model('settings/mdl_settings');
foreach ($arrayItems as $itemsF) {
    if ($itemsF) {
        ?>
    <table class="table_products" style="width: 100%;margin-top:20px">
        <?php $setting = $this->mdl_settings->gettypetaxeinvoice();?>
       
        <thead>
            <tr class="border-bottom-d tr_color">
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 80px;text-align: center;">Photo</th>
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 80px;"><?php echo lang('item_pdf'); ?></th>
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 600px;">
                    <?php echo lang('description'); ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
; text-align: center;" class="style_th"><?php echo lang('qte_pdf'); ?></th>                 
            </tr>
        </thead>
        
        <tbody>
            <?php        
$linecounter = 0;
        foreach ($itemsF as $item) {  
            $output = "";          
            $output .= "./uploads/";
$output .= strtolower($this->session->userdata('licence'));
$output .= "/fileproduct/";
$output .= $this->mdl_products->by_file($item->item_code)->name_file;
             if ($setting == 1) {
                ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
            <?php 
    //  var_dump($output);die();
    ?>
                <td style="text-align: center;font-size:11px; border-color: #888;">
                <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">                    
                <?php }?>
                </td>           
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php
                if($this->mdl_products->getDescription(trim($item->item_code),$fabrication->langue)=='none'){
                    echo nl2br($this->mdl_products->getDescription(trim($item->item_code),$fabrication->langue)->description);

                }else{
                    echo nl2br($item->item_description);
                } 
              // echo nl2br($item->item_description);
                 ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>      
            </tr>

            <?php } else {?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
            <td style="text-align: center;font-size:11px; border-color: #888;">
            <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">                    
                <?php }?>
                </td>     
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>           
            </tr>

            <?php $linecounter++;?>
            <?php }}?>
        </tbody>
    </table>
    <?php
}
}
?>
    <div>
        <!--zone de droite-->
        


        <!--remarque de gauche-->

        <div style="width:50%;float:left;">

            <p class=""
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo lang('msg_arret_fabrication'); ?>
                </p>
              
                <?php if ($fabrication->note !=" ") {?>
                <?php  if($fabrication->note){?>
            <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . $fabrication->notes; ?></p>
            <?php }elseif ($fabrication->quote_number != 0){?>
                <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . lang('creation_quote_fabrication')." ". $fabrication->quote_number; ?></p>
            <?php }}?>
        </div>

        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000"
            class="text-right"><?php echo lang('msg_merci'); ?></p>
    </div>
    <div style="width:25%;position:absolute;bottom:200px">
     
     <?php
     $sett=$this->mdl_settings->setting('signature_logo');
     if($this->mdl_settings->setting('signature_logo')){
     if($fabrication->signature==1){ ?>
        <img src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('signature_logo')); ?>">

     <?php }} ?>
   
    </div>
</body>

<!--
    langue diferent arabic
-->
     <?php }else{ ?>
        <body style="">
    <table style=" width: 100%">
        <?php
      $this->lang->load('ip_', $fabrication->langue);

      $this->load->helper('language');
    
     $this->load->module('layout');
if ($typepdf == 0) {
    ?>
        <tr>         
            <td style=" width:300px; ">
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
                <?php echo lang('tel') ?>  <?php echo $societe_tel; ?>:
                <!--Tél : 70 737 903 / 71 949 154-->
                <?php }?>
                <?php if ($societe_mail != '') {?>
                <br>
                <?php echo $societe_mail; ?>  <?php echo lang('email') ?> :
                <!--Email: commercial@novatis.tn-->
                <?php }?>
            </td>
            <td style=" width:75px "></td>
            <td style=" width:325px ;text-align:right;" >
                <div id="logo">
                    <?php $output = "./uploads/";
    $output .= strtolower($this->session->userdata('licence'));
    $output .= "/";
    $output .= $this->mdl_settings->setting('invoice_logo');
    ?>
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">

                </div>
            </td>
        </tr>    
        <tr>
            <td style="height:50px" >
            </td>
        </tr>      
        <tr>
            <td>
                <div id="devis_text" valign="top">
                    <?php $output = "./assets/default/img/logo_txt_fabrication-arabe.jpg";

    ?>
                    <img style=" width: 18%; margin-top:35px" src="<?php echo $output; ?>">

                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px;text-align:right; ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $fabrication->client_societe; ?></b><br>
                    <?php
if ($fabrication->client_titre == 0) {
        $client_titre = "السيد";
    } elseif ($fabrication->client_titre == 1) {
        $client_titre = "السيدة";
    } elseif ($fabrication->client_titre == 2) {
        $client_titre = "الآنسة";
    }
    ?>

                    <?php echo lang('attention_pdf')  . ' ' ?> <?php echo ($client_titre . ' ' . $fabrication->client_prenom . ' ' . $fabrication->client_name ) ; ?>
                    <br/>

                    <?php
if ($fabrication->client_address_1) {
        echo $fabrication->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_address_2) {
        echo $fabrication->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_zip) {
        echo $fabrication->client_zip . ' ';
    }
    ?>
                    <?php
if ($fabrication->client_city) {
        echo $fabrication->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($fabrication->client_state) {
        echo $fabrication->client_state . '&nbsp;';
    }
    if ($fabrication->client_country) {
        echo $countries[$fabrication->client_country] . '<br/>';
    }
    if ($fabrication->client_phone) {
        echo $fabrication->client_phone. '- ';
        if ($fabrication->client_mobile) {
            echo  $fabrication->client_mobile." ";
        }
      echo lang('tel') ;
        echo '<br/>';
    }
    ?>

                    <?php
if ($fabrication->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $fabrication->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $fabrication->client_mat_fiscal . '<br/>';
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
            <td style="height:50px" >
            </td>
        </tr>  
        <tr>
            <td>

                <div id="devis_text" valign="top">
                    <!--<img style="margin-left: 0px; width: 18%; margin-top:-25px"
                        src="<?php echo site_url('assets/default/img/logo_txt_fabrication-arabe.jpg'); ?>">
                        --><?php $output = "./assets/default/img/logo_txt_fabrication-arabe.jpg";

    ?>
                    <img style=" width: 18%; margin-top:35px" src="<?php echo $output; ?>">
                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px;text-align:right; ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $fabrication->client_societe; ?></b><br>
                    <?php
if ($fabrication->client_titre == 0) {
        $client_titre = "السيد";
    } elseif ($fabrication->client_titre == 1) {
        $client_titre = "السيدة";
    } elseif ($fabrication->client_titre == 2) {
        $client_titre = "الآنسة";
    }
    ?>

                    <?php echo lang('attention_pdf')  . ' ' ?> <?php echo ($client_titre . ' ' . $fabrication->client_prenom . ' ' . $fabrication->client_name ) ; ?>
                    <br/>

                    <?php
if ($fabrication->client_address_1) {
        echo $fabrication->client_address_1 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_address_2) {
        echo $fabrication->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_zip) {
        echo $fabrication->client_zip . ' ';
    }
    ?>
                    <?php
if ($fabrication->client_city) {
        echo $fabrication->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($fabrication->client_state) {
        echo $fabrication->client_state . '&nbsp;';
    }
    if ($fabrication->client_country) {
        echo $countries[$fabrication->client_country] . '<br/>';
    }
    if ($fabrication->client_phone) {
        echo $fabrication->client_phone. '- ';
        if ($fabrication->client_mobile) {
            echo  $fabrication->client_mobile." ";
        }
      echo lang('tel') ;
        echo '<br/>';
    }
    ?>

                    <?php
if ($fabrication->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $fabrication->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($fabrication->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $fabrication->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>
        </tr>

        <?php
}
?>
    </table>
   



    <table>
<tr>
    <td>
        <table style=" width: 36%;" align="left"  >
            <tr>
                <td>
                <span style=" font-family: Arial, Arial; font-stretch: ultra-expanded; font-size: 12; color: #000">
                    <?php
                        if ($fabrication->quote_date_expires != '0000-00-00') {
                            echo $fabrication->quote_date_expires;
                            echo '&nbsp;&nbsp;' . lang('quote_expire_le');
                            ?> : <?php

                        }
                        ?>
                </span>
                </td>
            </tr>
        </table>    
    </td> 
    <td>
            <table style=" width: 34%;" align="center"  >
            <tr>
            <td>
                    <span>
            <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
                <b>
                    <?php echo $fabrication->fabrication_nature; ?>
                </b>
            </p>
            </span>
   
            </td>
            </tr>
            </table>    
        
    </td>
   
    <td>
    <table style="width: 36%; "   align="right"  >
    <tr >
    
   
    <td>
    <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
    <?php 
    if ($fabrication->user_code != '') {
        echo $fabrication->user_code;
    } else {
        echo $fabrication->user_name;
    }
    ?> <?php echo lang('quote_par').' '; ?> 
   </span>
    </td>
    <td >
    <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
    <?php echo $fabrication->quote_date_created ;?> <?php echo lang('quote_Du').' '; ?> 
   </span>
    </td>
    <td>
    <span style=" text-align:right; font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
    <?php echo lang('bf').' رقم'; ?> <?php echo $this->mdl_settings->setting('prefix_fabrication') . $fabrication->fabrication_number; ?>
   </span>
    </td>
    </tr>
    </table>
        
        </td>
</tr>
</table>


    <?php
foreach ($devises as $value) {
    if ($fabrication->client_devise_id == $value->devise_id) {
        $dev_lab = $value->devise_label;
        $dev_symb = $value->devise_symbole;
    }
}
?>
    <?php
$this->load->model('settings/mdl_settings');
foreach ($arrayItems as $itemsF) {
    if ($itemsF) {
        ?>
    <table dir="rtl" class="table_products" style="width: 100%;margin-top:20px">
        <?php $setting = $this->mdl_settings->gettypetaxeinvoice();?>
       
        <thead>
            <tr class="border-bottom-d tr_color">
            <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 80px;text-align: center;"><?php echo lang('photo') ?></th>   
 <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 80px;text-align: center;"><?php echo lang('item_pdf'); ?></th>     
 <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
;width: 600px;text-align: center;">
                    <?php echo lang('description'); ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
            <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>
; text-align: center;" class="style_th"><?php echo lang('qte_pdf'); ?></th>  
               
               
               
                     
            </tr>
        </thead>
        
        <tbody>
            <?php        
$linecounter = 0;
        foreach ($itemsF as $item) {            
            $output = "./uploads/";
$output .= strtolower($this->session->userdata('licence'));
$output .= "/fileproduct/";
$output .= $this->mdl_products->by_file($item->item_code)->name_file;
             if ($setting == 1) {
                ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
            <?php 
    //  var_dump($output);die();
    ?>
     <td style="text-align: center;font-size:11px; border-color: #888;">
             <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                 <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">                    
             <?php }?>
             </td>    
    <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
    <td style="font-size:11px; border-color: #888;"><?php
                if($this->mdl_products->getDescription(trim($item->item_code),$fabrication->langue)=='none'){
                    echo nl2br($this->mdl_products->getDescription(trim($item->item_code),$fabrication->langue)->description);

                }else{
                    echo nl2br($item->item_description);
                } 
              // echo nl2br($item->item_description);
                 ?></td>           
              
     <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>    
                   
                   
            </tr>

            <?php } else {?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
            <td style="text-align: center;font-size:11px; border-color: #888;">
            <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $output; ?>">                    
                <?php }?>
                </td>     
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>           
            </tr>

            <?php $linecounter++;?>
            <?php }}?>
        </tbody>
    </table>
    <?php
}
}
?>
    <div>
        <!--zone de droite-->
        


        <!--remarque de gauche-->

        <div style="width:50%;float:left;">

            <p class=""
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo lang('msg_arret_fabrication'); ?>
                </p>
              
               <?php /*if ($fabrication->note !=" ") {?>
                <?php  if($fabrication->note){?>
            <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . $fabrication->notes; ?></p>
            <?php }elseif ($fabrication->quote_number != 0){?>
                <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . lang('creation_quote_fabrication')." ". $fabrication->quote_number; ?></p>
            <?php }}*/?>
        </div>

        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000"
            class="text-right"><?php echo lang('msg_merci'); ?></p>
    </div>
    <div style="width:25%;position:absolute;bottom:200px">
     
     <?php
     $sett=$this->mdl_settings->setting('signature_logo');
     if($this->mdl_settings->setting('signature_logo')){
     if($fabrication->signature==1){ ?>
        <img style="max-width:200px;max-height:120px;" src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('signature_logo')); ?>">

     <?php }} ?>
   
    </div>
</body>
     <?php } ?>
</html>