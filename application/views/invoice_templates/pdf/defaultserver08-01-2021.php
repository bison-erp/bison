
<style>
.trpdf {
    padding: 60px 10px
}
</style>

<?php
   
   function numtoarbapresvergule ($totall,$dev_symb)
{      //$totall = $totall[2][1];
    //var_dump(($totall)) ;
    $tab = array(
        0 => "صفر",
        1 => "واحد",
        2 => "اثنان",
        3 => "ثلاثة",
        4 => "أربعة",
        5 => "خمسة",
        6 => "ستة",
        7 => "سبعة",
        8 => "ثمانية",
        9 => "تسعة",
        10 => "عشرة",
        11 => "أحد عشر",
        12 => "اثنى عشر" ,
        13 => "ثلاثة عشر" ,
        14 => "أربعة عشر" ,
        15 => "خمسة عشر" ,
        16 => "ستة عشر" ,
        17 =>  "سبعة عشر" ,
        18 =>  "ثمانية عشر" ,
        19 =>  "تسعة عشر" ,
    );
    $tabb = array(     
        2 => "عشرون",
        3 => "ثلاثون",
        4 => "أربعون",
        5 => "خمسون",
        6 => "ستون",
        7 => "سبعون",
        8 => "ثمانون",
        9 => "تسعون",   
 );
        $strarb="";
        $total=explode(".",$totall);
        $pos1=$total[1];
        $j= strlen($total[0]);
        $je=$j;
        $je--;
        $de=1;
        for($i=1;$i<$j;$i++)
        $de=$de*10;

        $t=$total[0];

        for($i=0;$i<$j;$i++)
        {
        $te[$je]=$t/$de;
        $t=$t%$de;
        $de=$de/10;
        $temp=explode(".",$te[$je]);
        $te[$je]=$temp[0];
        $je--;

        }
      //  98
        // return $total[0][1];
         //return var_dump(($total[0])) ;
     
        // array_keys($tab) ;

        
        if ($j==2)  {
            if($total[0]<100){
                if($total[0]<20){
                   if($total[0]<10 && $total[0]!=0 ){
                       $strarb= $tab[$total[0][1]];  
                   }else{
                       $strarb= $tab[$total[0]];  
                   } 
                   
               }else{
                 $var=$total[0][1];
                 $var1=$total[0][0];
                 if($total[0]>0){
                    
                 $reste = fmod($total[0] , 10);
                 
                 if($reste>0){
                    if($var>0){
                        $strarb=$tab[$var].'و'.$tabb[$var1];
                      }else{
                        $strarb=  $tabb[$var1];
                      }
                 }else{
                     $strarb=  $tabb[(int)($total[0]/10)];
                 }
                }
                // return $var;
                 
                
               }
           }
            
             /*  $arb[0]= $te;   
               return $te[1]
            }else{
                
                $arb[0]=$tab[$te[0]]. ' و ' .$tabb[$te[0]];
            }*/
        
        }else{
        for($i=0;$i<$j;$i++)
        {

                if ($i == 0)
                {
                    if ($j<3)
                switch($te[$i])
                {
                case "0" : $arb[0]=" ";
                break;
                case "1" :  $arb[0]= " واحد"  ;
                break;
                case "2" : if($te[1]=="1") $arb[0]=" اثنا "; else $arb[0]=" اثنان" ;
                break;
                case "3" : $arb[0]=" ثلاثة";
                break;
                case "4" : $arb[0]=" اربعة" ;
                break;
                case "5" : $arb[0]=" خمسة"   ;
                break;
                case "6" : $arb[0]=" ستة"     ;
                break;
                case "7" : $arb[0]=" سبعة"     ;
                break;
                case "8" : $arb[0]=" ثمانية"    ;
                break;
                case "9" : $arb[0]=" تسعة"       ;
                break;
                }
                if ($j<3)
                switch($te[$i])
                {
                case "0" : $arb[0]=" ";
                break;
                case "1" :  $arb[0]= " واحد"  ;
                break;
                case "2" : if($te[1]=="1") $arb[0]=" اثنا "; else $arb[0]=" اثنان" ;
                break;
                case "3" : $arb[0]=" ثلاثة";
                break;
                case "4" : $arb[0]=" اربعة" ;
                break;
                case "5" : $arb[0]=" خمسة"   ;
                break;
                case "6" : $arb[0]=" ستة"     ;
                break;
                case "7" : $arb[0]=" سبعة"     ;
                break;
                case "8" : $arb[0]=" ثمانية"    ;
                break;
                case "9" : $arb[0]=" تسعة"       ;
                break;
                }
                else
                switch($te[$i])
                {
                case "0" : $arb[0]=" ";
                break;
                case "1" :  $arb[0]=" وواحد"  ;
                break;
                case "2" : if($te[1]=="1") $arb[0]=" واثنا "; else $arb[0]=" واثنان" ;
                break;
                case "3" : $arb[0]=" وثلاثة";
                break;
                case "4" : $arb[0]=" واربعة" ;
                break;
                case "5" : $arb[0]=" وخمسة"   ;
                break;
                case "6" : $arb[0]=" وستة"     ;
                break;
                case "7" : $arb[0]=" وسبعة"     ;
                break;
                case "8" : $arb[0]=" وثمانية"    ;
                break;
                case "9" : $arb[0]=" وتسعة"       ;
                break;
                }
                }
        
        
        
                if ($i == 1)
                {
                if ($j==2 )
                {
                if($te[$i]==1){if($te[0]=="1") {$arb[0]=" " ;$arb[1]=" أحد عشر";}  elseif($te[0]=="0")$arb[1]=" عشرة"; else $arb[1]=" عشر"    ; }
                if ( $te[0]=="0")
                switch($te[$i])
                {
                case "0" : $arb[1]=" "      ;
                break;
                case "1" : if($te[0]=="1") {$arb[0]=" " ;$arb[1]=" أحد عشر";} elseif($te[0]=="0")$arb[1]=" عشرة"; else $arb[1]="عشر"    ;
                break;
                case "2" : $arb[1]=" عشرون"    ;
                break;
                case "3" : $arb[1]=" ثلاثون"    ;
                break;
                case "4" : $arb[1]=" اربعون"     ;
                break;
                case "5" : $arb[1]=" خمسون"       ;
                break;
                case "6" : $arb[1]=" ستون"         ;
                break;
                case "7" : $arb[1]=" سبعون"         ;
                break;
                case "8" : $arb[1]=" ثمانون"         ;
                break;
                case "9" : $arb[1]=" تسعون"           ;
                break;
                }
        
                }
                else
                switch($te[$i])
                {
                case "0" : $arb[1]=" "      ;
                break;
                case "1" : if($te[0]=="1") {$arb[0]=" " ;$arb[1]=" وأحد عشر";}elseif($te[0]=="0")$arb[1]=" وعشرة"; else $arb[1]=" عشر"  ;
                break;
                case "2" : $arb[1]=" وعشرون"    ;
                break;
                case "3" : $arb[1]=" وثلاثون"    ;
                break;
                case "4" : $arb[1]=" واربعون"     ;
                break;
                case "5" : $arb[1]=" وخمسون"       ;
                break;
                case "6" : $arb[1]=" وستون"         ;
                break;
                case "7" : $arb[1]=" وسبعون"         ;
                break;
                case "8" : $arb[1]=" وثمانون"         ;
                break;
                case "9" : $arb[1]=" وتسعون"           ;
                break;
                }
                }
        
        
                if ($i == 2)
                {
                if ($j==3)
                switch($te[$i])
                {
                case "0" : $arb[2]=" "      ;
                break;
                case "1" : $arb[2]=" مائة"    ;
                break;
                case "2" : $arb[2]=" مائتان"    ;
                break;
                case "3" : $arb[2]=" ثلاثمائة"    ;
                break;
                case "4" : $arb[2]=" اربعمائة"     ;
                break;
                case "5" : $arb[2]=" خمسمائة"       ;
                break;
                case "6" : $arb[2]=" ستمائة"         ;
                break;
                case "7" : $arb[2]=" سبعمائة"         ;
                break;
                case "8" : $arb[2]=" ثمانمائة"         ;
                break;
                case "9" : $arb[2]=" تسعمائة"           ;
                break;
                }
                else
                switch($te[$i])
                {
                case "0" : $arb[2]=" "      ;
                break;
                case "1" : $arb[2]=" ومائة"    ;
                break;
                case "2" : $arb[2]=" ومائتان"    ;
                break;
                case "3" : $arb[2]=" وثلاثمائة"    ;
                break;
                case "4" : $arb[2]=" واربعمائة"     ;
                break;
                case "5" : $arb[2]=" وخمسمائة"       ;
                break;
                case "6" : $arb[2]=" وستمائة"         ;
                break;
                case "7" : $arb[2]=" وسبعمائة"         ;
                break;
                case "8" : $arb[2]=" وثمانمائة"         ;
                break;
                case "9" : $arb[2]=" وتسعمائة"           ;
                break;
                }
                }
        
                if ($i == 3)
                {
                if($j==4)
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" ألف"    ;
                break;
                case "2" : $arb[$i]=" ألفان"    ;
                break;
                case "3" : $arb[$i]=" ثلاثة آلاف"    ;
                break;
                case "4" : $arb[$i]=" اربعة آلاف"     ;
                break;
                case "5" : $arb[$i]=" خمسة آلاف"       ;
                break;
                case "6" : $arb[$i]=" ستة آلاف"         ;
                break;
                case "7" : $arb[$i]=" سبعة آلاف"         ;
                break;
                case "8" : $arb[$i]=" ثمانية آلاف "         ;
                break;
                case "9" : $arb[$i]=" تسعة آلاف "           ;
                break;
                }
                elseif ($j==5)
        
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" واحد "    ;
                break;
                case "2" : if($te[6]=="1") $arb[$i]=" اثنا "; else $arb[$i]=" اثنان" ;
                break;
                case "3" : $arb[$i]=" ثلاثة "    ;
                break;
                case "4" : $arb[$i]=" اربعة "     ;
                break;
                case "5" : $arb[$i]=" خمسة "       ;
                break;
                case "6" : $arb[$i]=" ستة "         ;
                break;
                case "7" : $arb[$i]=" سبعة "         ;
                break;
                case "8" : $arb[$i]=" ثمانية "         ;
                break;
                case "9" : $arb[$i]=" تسعة "           ;
                }
        
                else
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" وواحد "    ;
                break;
                case "2" : if($te[4]=="1") $arb[$i]=" واثنا "; else $arb[$i]=" واثنان" ;
                break;
                case "3" : $arb[$i]=" وثلاثة "    ;
                break;
                case "4" : $arb[$i]=" واربعة "      ;
                break;
                case "5" : $arb[$i]=" وخمسة "       ;
                break;
                case "6" : $arb[$i]=" وستة "         ;
                break;
                case "7" : $arb[$i]=" وسبعة "         ;
                break;
                case "8" : $arb[$i]=" وثمانية "         ;
                break;
                case "9" : $arb[$i]=" وتسعة "           ;
                }
                }
                if ($i == 4)
                {
                if($j==5 )
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : if($te[3]=="1") {$arb[3]=" " ;$arb[4]=" أحد عشر الفا";} elseif($te[3]=="0")$arb[4]=" عشرة آلاف";else$arb[$i]=" عشر الفا"    ;
                break;
                case "2" : $arb[$i]=" عشرون "    ;
                break;
                case "3" : $arb[$i]=" ثلاثون "    ;
                break;
                case "4" : $arb[$i]=" اربعون "     ;
                break;
                case "5" : $arb[$i]=" خمسون "       ;
                break;
                case "6" : $arb[$i]=" ستون "         ;
                break;
                case "7" : $arb[$i]=" سبعون "         ;
                break;
                case "8" : $arb[$i]=" ثمانون "         ;
                break;
                case "9" : $arb[$i]=" تسعون "           ;
                break;
                }
                else
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : if($te[3]=="1") {$arb[3]=" " ;$arb[4]=" وأحد عشر الفا";} elseif($te[3]=="0")$arb[4]=" وعشرة آلاف";else$arb[$i]=" عشر الفا"    ;
                break;
                case "2" : $arb[$i]=" وعشرون "     ;
                break;
                case "3" : $arb[$i]=" وثلاثون "    ;
                break;
                case "4" : $arb[$i]=" واربعون "     ;
                break;
                case "5" : $arb[$i]=" وخمسون "       ;
                break;
                case "6" : $arb[$i]=" وستون "         ;
                break;
                case "7" : $arb[$i]=" وسبعون "         ;
                break;
                case "8" : $arb[$i]=" وثمانون "         ;
                break;
                case "9" : $arb[$i]=" وتسعون "           ;
                break;
                }
                }
                if ($i == 5)
                {
                if ($j==6)
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" مائة "    ;
                break;
                case "2" : $arb[$i]=" مائتان "    ;
                break;
                case "3" : $arb[$i]=" ثلاثمائة "    ;
                break;
                case "4" : $arb[$i]=" اربعمائة "     ;
                break;
                case "5" : $arb[$i]=" خمسمائة "       ;
                break;
                case "6" : $arb[$i]=" ستمائة "         ;
                break;
                case "7" : $arb[$i]=" سبعمائة "           ;
                break;
                case "8" : $arb[$i]=" ثمانمائة "         ;
                break;
                case "9" : $arb[$i]=" تسعمائة "           ;
                break;
                }
                else
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" ومائة "    ;
                break;
                case "2" : $arb[$i]=" ومائتان "    ;
                break;
                case "3" : $arb[$i]=" وثلاثمائة "    ;
                break;
                case "4" : $arb[$i]=" واربعمائة "     ;
                break;
                case "5" : $arb[$i]=" وخمسمائة "       ;
                break;
                case "6" : $arb[$i]=" وستمائة "         ;
                break;
                case "7" : $arb[$i]=" وسبعمائة "           ;
                break;
                case "8" : $arb[$i]=" وثمانمائة "         ;
                break;
                case "9" : $arb[$i]=" وتسعمائة "           ;
                break;
                }
                }
        
                if ($i == 6)
                switch($te[$i])
                {
                case "0" : $arb[$i]=" "      ;
                break;
                case "1" : $arb[$i]=" مليون "    ;
                break;
                case "2" : $arb[$i]=" مليونان "    ;
                break;
                case "3" : $arb[$i]=" ثلاثة ملايين "    ;
                break;
                case "4" : $arb[$i]=" اربعة ملايين "     ;
                break;
                case "5" : $arb[$i]=" خمسة ملايين "       ;
                break;
                case "6" : $arb[$i]=" تة ملايين "         ;
                break;
                case "7" : $arb[$i]=" سبعة ملايين "           ;
                break;
                case "8" : $arb[$i]=" ثمانية ملايين "         ;
                break;
                case "9" : $arb[$i]=" تسعة ملايين "           ;
                break;
                }
                }
        
        
        
        
                if($j>4 && $te[4]!="1")
                $arb[4]=$arb[4]." الف ";
        
        
                $strarb=$arb[6].$arb[5].$arb[3].$arb[4].$arb[2].$arb[0].$arb[1];
               
              //  return $strarb;
                // Notation anglaise sans séparateur de milliers
        //$english_format_number = number_format($total[1], 2, '.', '');
        //$pos1
        //numtoarb
               
            }
            return  $strarb;
        
} 

 
   
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
<?php
 $this->load->model('products/mdl_products');
 ?>
<?php if($invoice->langue!="Arabic"){ 
      $this->lang->load('ip_', $invoice->langue);
		
      $this->load->helper('language');
    
     $this->load->module('layout');
    ?>

<body style="">

    <table style=" width: 100%" >
        <tr>
            <?php if ($typepdf == 0) {?>
          
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
            <td style=" width:300px; text-align:right;">
                   
                <div id="logo">

<img style="ext-align:right;max-width:200px;max-height:100px;"
                        src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('invoice_logo')); ?>">

                    </div>

            </td>
           
            <?php } elseif ($typepdf == 1) {?>
            <td class="trpdf"></td>
            <?php }?>
        </tr>
        <tr>
            <td style="height:50px" >
            </td>
        </tr>    
      
        <tr>
           
            
            <td valign="bottom" style="text-align:left; width:325px ">
                <br><span style="font-size: 13; color:#333;text-align:left;">
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
                <td colspan="2" style=" width:75px "></td>
            <td style=" width:100px ;text-align:right;">
                 <div id="devis_text" valign="top">
                 
                 <?php 
                     $output ="";
                     if($invoice->langue=="English"){
                         $output = "./assets/default/img/logo_txt_fact_en.jpg";
                     }else{
                         $output = "./assets/default/img/logo_txt_fact.png";
                     } 
 ?>
                     <img style=" width: 21%; margin-top: 35px" src="<?php echo $output; ?>">
 
                     <!--  <img style=" width: 18%; margin-top:-25px"
                         src="<?php echo site_url('assets/default/img/logo_txt_fact.png'); ?>">
 -->
                 </div>
            
            
            </td>

        </tr>



    </table>
    <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
        <b>
            <?php echo $invoice->nature; ?>
        </b>
    </p>

    <table >
    <tr>
        <td>

    <br> <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo lang('num/ref') . '&nbsp;:&nbsp;' . lang('invoice'); ?>
       <b>  <?php echo $this->mdl_settings->setting('prefix_invoice') . $invoice->invoice_number; ?></b>
       <?php echo lang('quote_Du'); ?>
       <b>  <?php echo date_from_mysql($invoice->invoice_date_created, true); ?></b>
        <?php echo lang('quote_par'); ?>
        <?php
if ($invoice->user_code != '') {
    echo strtoupper($invoice->user_code);
} else {
    echo strtoupper($invoice->user_name);
}
?>
    </span>

    </td>
    <td style="text-align:right">
    <span style=" font-family: Arial, Arial; font-stretch: ultra-expanded; font-size: 12; color: #000">
        <?php
$dlai = '';
foreach ($delai as $value) {
    if ($value->delai_paiement_id == $invoice->invoice_delai_paiement) {
        $dlai = $value->delai_paiement_label;
    }

}
if ($dlai != '') {
   // echo lang('CdtsReglement') . ': ';
   // echo $dlai;
}
?>
        <br />
        <?php
if ($invoice->invoice_date_due != '0000-00-00') {
    echo lang('quote_expire_le') . ': ' . date_from_mysql($invoice->invoice_date_due, true);
}
?>
    </span>
    
    </td>
    </tr>
    </table>
   

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
            <?php if($invoice->photo==1){ ?>
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
width: 80px;text-align: center;">Photo</th>
            <?php  } ?>    
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
width: 100px;"><?php echo lang('item_pdf'); ?></th>
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
width: 250px;">
                    <?php echo lang('description'); ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
        if ($setting == 1) {
            ?>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;" class="style_th"><?php echo lang('qte_pdf'); ?></th>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;" class="style_th"><?php echo lang('price_pdf'); ?></th>
                <?php } else {?>
                <th style=" color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
text-align: center;" class="style_th"> Quantité </th>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;" class="style_th">PU (DT)</th>
                <?php }?>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
        if ($setting == 1) {
            ?>
                <th style=" color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
text-align: center;" class="style_th"><?php echo lang('tva_pdf'); ?></th>
                <?php }?>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;" class="style_th"><?php echo lang('total'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
$linecounter = 0;
$this->load->library('image_lib');
        foreach ($itemsF as $item) {
            ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
            <?php if($invoice->photo==1){         
                  $outputprod = "" ;       
                  $outputprod .= "./uploads/";
                  $outputprod .= strtolower($this->session->userdata('licence'));
                  $outputprod .= "/fileproduct/";
                  $outputprod .= $this->mdl_products->by_file($item->item_code)->name_file;
                
                ?>
            <?php } ?>
                <?php if($invoice->photo==1){?>      
                <td style="font-size:11px; border-color: #888;">
                <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                
                    <img style="max-width:200px;max-height:100px;" src="<?php echo $outputprod; ?>">                    
                <?php }?>
                </td>    
                <?php } ?>       
                <td style="font-size:11px; border-color: #888;"><?php echo $item->item_code; ?></td>
                <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>
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
            <table border="0">
                <tr>
                    <td class="text-right">
                        <table class="" style="width: 250px; font-size:12px;">
                            <?php if ($invoice->invoice_pourcent_remise != 0) {?>
                            <tr>
                               
                                <th class="text-right td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;border:#5e5e5e solid 1px; padding:5px;">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_remise, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th class="text-right" style="right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;width: 150px; padding:5px;  ">
                                    <?php echo lang('remise_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_remise;
    echo $rem;
    ?> %</th>
                            </tr>
                            <?php }?>
                        </table>

                        <table class="tables_calculs" border="0" cellpadding="0" cellspacing="0" style="width: 250px">
                            <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                            <tr>
                            <th class="td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;width: 150px;"><?php echo lang('total_pdf'); ?>
                                     </th>
                            <th class="text-right td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->client_devise_id, 0); ?>
                                </th>
                               
                               
                            </tr>
                            <tr>
                                <td class=""  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b> 
                                        <?php echo lang('tva_pdf2'); ?></b></td>
                                <td class="text-right"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b>
                                        <?php echo format_devise($invoice->invoice_item_tax_total, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                            </tr>
                            <?php } else {?>
                            <tr>
                                <th class="td_backgrounded" style="width: 150px;"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    Total (DT):</th>
                                <th class="text-right td_backgrounded"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>

                            <?php }?>
                            <?php  if ($this->mdl_settings->setting('with_timbre')  != 0) {?>

                            <?php  if ($invoice->timbre_fiscale != 0) {?>

                            <tr>
                                <td class=""  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b><?php echo lang('timbre_pdf'); ?> </b></td>
                                <td class="text-right "  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b>
                                        <?php echo format_devise($invoice->timbre_fiscale, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                            </tr>

                            <?php }} ?>
                            <tr style=" display: none" class="amount-total border-top-n">
                                <td style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="td_backgrounded"><b><?php echo lang('total_amount'); ?>  <?php echo lang('ttc'); ?></b></td>
                                <td class="text-right color-d td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
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


                            <?php
                             if ($invoice->invoice_pourcent_acompte != 0) {?>

                            <tr>
                                <th class="td_backgrounded"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><?php echo lang('acompte_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_acompte;
        echo $rem;
        ?> %</th>
                                <th class="text-right td_backgrounded"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_acompte, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="td_backgrounded"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><?php echo lang('rest_pdf'); ?></th>
                                <th class="text-right td_backgrounded"  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
                                </th>
                            </tr>
                            <?php } else {?>
                            
                            <tr>
                               <!-- <th class="td_backgrounded"  style="color: <?php //echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"> <?php //echo lang('rest_pdf'); ?></th>
                                <th class="text-right td_backgrounded"  style="color: <?php //echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php //echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
                                </th>
                                -->
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
<br>
        <div style="width:50%;float:left;">

            <p class=""
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo lang('msg_arret_fact'); ?> 
                <?php
//echo
$rest ="";
$this->load->helper('numbertowords');
if($invoice->langue=="French"){
   $rest = int2str($invoice->invoice_total, $dev_symb);
}else{
   $ress=format_devise($invoice->invoice_total, $invoice->client_devise_id, 0);
   $replaced = str_replace(' ', '',$ress);
   $rest = numberTowords($replaced,$dev_symb);
}  
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
    <div style="width:25%;position:absolute;bottom:120px">

    <br>
     <?php
     $sett=$this->mdl_settings->setting('signature_logo');
     if($this->mdl_settings->setting('signature_logo')){
     if($invoice->signature==1){ ?>
        <img style="max-width:100px;max-height:120px;" src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('signature_logo')); ?>">

     <?php }} ?>
   
    </div>
</body>
<!-- langue  arabic  -->
     <?php }else{ ?>
     
        <body style="">
        <table style=" width: 100%">
        <?php
      $this->lang->load('ip_', $invoice->langue);
		
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

                    <?php $output = "./assets/default/img/logo_txt_invoice-arabe.jpg";

    ?>
                    <img style=" width: 18%; margin-top: 35px" src="<?php echo $output; ?>">

																	
																							  
   
                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px;text-align:right; ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $invoice->client_societe; ?></b><br>
                    <?php
if ($invoice->client_titre == 0) {
        $client_titre = "السيد";
    } elseif ($invoice->client_titre == 1) {
        $client_titre = "السيدة";
    } elseif ($invoice->client_titre == 2) {
        $client_titre = "الآنسة";
    }
											  
    ?>

                    <?php echo lang('attention_pdf')  . ' ' ?> <?php echo ($client_titre . ' ' . $invoice->client_prenom . ' ' . $invoice->client_name ) ; ?>
                    <br/>

                    <?php
if ($invoice->client_address_1) {
        echo $invoice->client_address_1 . '<br/>';		  
											 
    }
    ?>
                    <?php
if ($invoice->client_address_2) {
        echo $invoice->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($invoice->client_zip) {
        echo $invoice->client_zip . ' ';
    }
    ?>
                    <?php
if ($invoice->client_city) {
        echo $invoice->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($invoice->client_state) {
        echo $invoice->client_state . '&nbsp;';
    }
    if ($invoice->client_country) {
        echo $countries[$invoice->client_country] . '<br/>';
    }
    if ($invoice->client_phone) {
        echo $invoice->client_phone. '- ';
        if ($invoice->client_mobile) {
            echo  $invoice->client_mobile." ";
        }
      echo lang('tel') ;
        echo '<br/>';
    }
    ?>
							
										   

                    <?php
if ($invoice->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $invoice->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($invoice->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $invoice->client_mat_fiscal . '<br/>';
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

                    <?php $output = "./assets/default/img/logo_txt_invoice-arabe.jpg";

    ?>
                    <img style=" width: 18%; margin-top:35px" src="<?php echo $output; ?>">

																	
																							  
   
                </div>
            </td>
            <td style=" width:75px "></td>
            <td valign="bottom" style=" width:315px;text-align:right; ">
                <br><span style="font-size: 13; color:#333">
                    <b style="color:#000"><?php echo $invoice->client_societe; ?></b><br>
                    <?php
if ($invoice->client_titre == 0) {
        $client_titre = "السيد";
    } elseif ($invoice->client_titre == 1) {
        $client_titre = "السيدة";
    } elseif ($invoice->client_titre == 2) {
        $client_titre = "الآنسة";
    }
											  
    ?>

                    <?php echo lang('attention_pdf')  . ' ' ?> <?php echo ($client_titre . ' ' . $invoice->client_prenom . ' ' . $invoice->client_name ) ; ?>
                    <br/>

                    <?php
if ($invoice->client_address_1) {
        echo $invoice->client_address_1 . '<br/>';		  
											 
    }
    ?>
                    <?php
if ($invoice->client_address_2) {
        echo $invoice->client_address_2 . '<br/>';
    }
    ?>
                    <?php
if ($invoice->client_zip) {
        echo $invoice->client_zip . ' ';
    }
    ?>
                    <?php
if ($invoice->client_city) {
        echo $invoice->client_city . '<br/> ';
    }
    ?>

                    <?php
if ($invoice->client_state) {
        echo $invoice->client_state . '&nbsp;';
    }
    if ($invoice->client_country) {
        echo $countries[$invoice->client_country] . '<br/>';
    }
    if ($invoice->client_phone) {
        echo $invoice->client_phone. '- ';
        if ($invoice->client_mobile) {
            echo  $invoice->client_mobile." ";
        }
      echo lang('tel') ;
        echo '<br/>';
    }
    ?>
							
										   

                    <?php
if ($invoice->client_tax_code) {
        echo lang('registre_commerce_pdf') . ': ' . $invoice->client_tax_code . '<br/>';
    }
    ?>
                    <?php
if ($invoice->client_mat_fiscal) {
        echo lang('matricule_fisc_pdf') . ': ' . $invoice->client_mat_fiscal . '<br/>';
    }
    ?>

                </span></td>
            <td style=" width:10px ">
            </td>
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
 
                <br />
                <?php
                if ($invoice->invoice_date_due != '0000-00-00') {
                echo $invoice->invoice_date_due.' ';  echo lang('quote_expire_le') . ': ' ;
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
        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000;text-align:center">
            <b>
                <?php echo $invoice->nature; ?>
            </b>
        </p>
        
        </td>
        </tr>
        </table>
        
    </td>
    <td>
        <table style="width: 34%; " align="right" >
        <tr> 
        <td>
        <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php 
        if ($invoice->user_code != '') {
            echo $invoice->user_code;
        } else {
            echo $invoice->user_name;
        }
        ?> <?php echo lang('quote_par').' '; ?> 
    </span>
        </td>
        <td >
        <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo $invoice->invoice_date_created ;?> <?php echo lang('quote_Du').' '; ?> 
    </span>
        </td>
        <td>
        <span style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; color: #000; font-size: 12">
        <?php echo lang('invoice').' رقم'; ?> <?php echo $this->mdl_settings->setting('prefix_invoice') . $invoice->invoice_number; ?>
    </span>
        </td>
        </tr>
        </table>


    </td>
    </tr>
    </table>
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
    <table dir="rtl" class="table_products" style="width: 100%;margin-top:20px">
        <thead>
            <tr class="border-bottom-d tr_color">
            <?php if($invoice->photo==1){ ?>
                <th class="style_th" style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
width: 80px;text-align: center;"><?php echo lang('photo') ?></th>
            <?php  } ?>    
                
                <th class="style_th" style="text-align: center;width: 350px;color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;">
                    <?php echo lang('description'); ?><?php //if (count($itemsF) != 0) { echo $itemsF[0]->family_name; }        ?>
                </th>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
        if ($setting == 1) {
            ?>
                <th style=" color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
text-align: center;" class="style_th"><?php echo lang('qte_pdf'); ?></th>
                <th style=" color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
text-align: center;" class="style_th"><?php echo lang('price_pdf'); ?></th>
                <?php } else {?>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;" class="style_th"> الكمية </th>
                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
 text-align: center;width: 80px;" class="style_th">سعر الوحدة</th>
                <?php }?>               
                <th style=" color: <?php echo $this->mdl_settings->setting('clr_pdf') ?>;
text-align: center;width: 80px;" class="style_th"><?php echo lang('total_pdf'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
$linecounter = 0;

        foreach ($itemsF as $item) {
            if($invoice->photo==1){         
                $outputprod = "" ;       
                $outputprod .= "./uploads/";
                $outputprod .= strtolower($this->session->userdata('licence'));
                $outputprod .= "/fileproduct/";
                $outputprod .= $this->mdl_products->by_file($item->item_code)->name_file;
            }
            ?>
            <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '') ?>">
               <?php if($invoice->photo==1){?>      
                    <td style="font-size:11px; border-color: #888;">
                        <?php if($this->mdl_products->by_file($item->item_code)->name_file){ ?>
                            <img style="max-width:200px;max-height:100px;" src="<?php echo $outputprod; ?>">                    
                        <?php }?>
                    </td>    
                <?php } ?>     
                 <td style="font-size:11px; border-color: #888;"><?php echo nl2br($item->item_description); ?></td>
                <td class="text-center" style="font-size:10px; border-color: #888;">
                    <?php echo $item->item_quantity; ?></td>
                <td class="text-right" style="font-size:11px; border-color: #888;">
                    <?php echo format_devise($item->item_price, $invoice->client_devise_id); ?></td>
                <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
            if ($setting == 1) {
                ?>
               
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
            <div style="font-family: Arial; border:1px solid #000;font-size:10px;padding:20px;text-align:right">
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
                               
                                <th class="text-right td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;border:#5e5e5e solid 1px; padding:5px;">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_remise, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th class="text-right" style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;width: 150px; padding:5px;  ">
                                    <?php echo lang('remise_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_remise;
    echo $rem;
    ?> %</th>
                            </tr>
                            <?php }?>
                        </table>

                        <table class="tables_calculs" border="0" cellpadding="0" cellspacing="0" style="width: 250px">
                            <?php $setting = $this->mdl_settings->gettypetaxeinvoice();
if ($setting == 1) {
    ?>
                            <tr>
                             
                                <th class="text-right td_backgrounded" style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;">
                                    <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th class="td_backgrounded" style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;width: 150px;"><?php ##echo lang('total_pdf'); ?>
                                     <?php  //echo 'المبلغ '; ?><?php echo lang('total_pdf'); ?> </th>
                            </tr>
                            <tr>
                               
                                <td style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="text-right"><b>
                                        <?php echo format_devise($invoice->invoice_item_tax_total, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                                <td class="" style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b>
                                        <?php echo lang('tvatotal'); ?></b></td>
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
                            <?php  if ($this->mdl_settings->setting('with_timbre')  != 0) {?>
                            <?php if ($invoice->timbre_fiscale != 0) {?>

                            <tr>
                                <td class="text-right "><b>
                                        <?php // echo format_devise($invoice->timbre_fiscale, $invoice->client_devise_id, 0); ?>
                                    </b>
                                </td>
                                <td class="" style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"><b><?php echo lang('timbre_pdf'); ?> </b></td>

                            </tr>

                            <?php }}?>
                           
                            <tr style=" display: none" class="amount-total border-top-n">
                              
                                <td style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"  class="text-right color-d td_backgrounded">
                                    <b><?php echo format_devise($invoice->invoice_total, $invoice->client_devise_id, 0); ?></b>
                                </td>
                                <td style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="td_backgrounded"><b><?php ##echo lang('total_pdf'); ?> <?php ##echo $dev_symb; ?>
                                        <?php echo lang('ttc'); ?></b></td>
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
                              
                                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"  class="text-right td_backgrounded">
                                    <?php echo '-' . format_devise($invoice->invoice_montant_acompte, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="td_backgrounded"><?php echo lang('acompte_pdf'); ?> <?php
$rem = (float) $invoice->invoice_pourcent_acompte;
        echo $rem;
        ?> %</th>
                            </tr>
                            <tr>
                                <th  style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;"  class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="td_backgrounded"><?php echo lang('rest_pdf'); ?> </th>

                            </tr>
                            <?php } else {?>
                            <tr>
                                <th style="color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="text-right td_backgrounded">
                                    <?php echo format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0); ?>
                                </th>
                                <th style="text-align: right;color: <?php echo $this->mdl_settings->setting('clr_pdf_somme') ?>;" class="td_backgrounded"><?php echo lang('total_a_payer_pdf'); ?> </th>

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

        <div style="width:100%;float:right;margin-right:-900px">
  
            <p class=""
                style="text-align:right; font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo lang('msg_arret_fact'); ?><br>
                <br>
                <?php
 
$rsss= format_devise($invoice->invoice_balance, $invoice->client_devise_id, 0);
//$rsss1= number_format($rsss, 2);
$totalres=explode(".",$rsss);
 $replaced = str_replace(' ', '', $totalres[0]);
$replaced1 = str_replace(' ', '', $totalres[1]);
//echo money_format('%.2n', $totalres[1]);
  
$ch1= numtoarbapresvergule($replaced,$dev_symb);
// echo $replaced;
$ch2= numtoarbapresvergule($replaced1,$dev_symb);
 
$rest =  $ch1.' '.$dev_symb.' '.$ch2;
 
 $pos1 = stripos($rest, 'DT');
if ($pos1 != '') {
    $res1 = str_replace('DT', ' دينار ', $rest);
    echo $res1  ;
  //  echo $res1 . ' مليم';
}
$pos2 = stripos($rest, '$');
if ($pos2 != '') {
    $res2 = str_replace('$', ' دولار ', $rest);
    echo $res2  ;
  //  echo $res2 . ' سنت';
}
$pos3 = stripos($rest, '€');
if ($pos3 != '') {
    $res3 = str_replace('€', ' يورو ', $rest);
    //echo $res3 . ' سنتا';
    echo $res3  ;
} 
//echo $rest;

//echo  $ch2.' '.$ch1;

?>
                </p>
            <?php
/*if (trim($invoice->invoice_terms) != "") {?>
            <p
                style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000; width:100%">
                <?php echo "<b>" . lang('notes') . ":</b> " . $invoice->invoice_terms; ?></p>
            <?php }*/?>

        </div>
        <div style="clear:both"></div>
        <p style=" font-family:Verdana, sans-serif; font-stretch: ultra-expanded; font-size: 12px; color: #000"
            class="text-right"><?php echo lang('msg_merci'); ?></p>
    </div>
    <div style="width:25%;position:absolute;bottom:120px">
    
     <?php
     $sett=$this->mdl_settings->setting('signature_logo');
     if($this->mdl_settings->setting('signature_logo')){
     if($invoice->signature==1){ ?>
        <img style="max-width:100px;max-height:120px;" src="<?php echo base_url('uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting('signature_logo')); ?>">

     <?php }} ?>
   
    </div>
    
</body>
     <?php }?>
</html>