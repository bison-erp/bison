<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * InvoicePlane
 *
 * A free and open source web based invoicing system
 *
 * @package        InvoicePlane
 * @author        Kovah (www.kovah.de)
 * @copyright    Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license        https://invoiceplane.com/license.txt
 * @link        https://invoiceplane.com
 *
 */

class Mdl_Stock extends Response_Model
{

    public $table = 'ip_stock';
    public $primary_key = 'ip_stock.stock_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_stock.stock_id');
    }

    public function default_join()
    {  
        $this->db->join('ip_products', 'ip_stock.produit_id = ip_products.product_id', 'left');    
      
    }
 
    public function create($db_array = null)
    {

        $stock_id = parent::save(null, $db_array);

        // Create an stock amount record

        return $stock_id;
    } 

    public function stockdeclinaison($code,$quantite,$id_post,$module)
    {
        $this->load->model('products/mdl_stockmvt');
        // 0 invoice , 1 BL   
        $query = $this->mdl_stock->where('ref_stock', trim($code)); 
        $query = $this->mdl_stock->get()->result();
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $settings = get_settings_superadmin();
        $from = $settings['noreplay_mail'];
        $to = $this->session->userdata['user_mail'];
        $restant = 0;
        $restant_tot = 0;
        if($module==0){    
            if (count($query) > 0) {
                  $restant = $query[0]->virtual_stock + $quantite;
            }
            
            if($quantite!=0){
                $data_stockmvt = array(
                    'module' => $module, 
                    'module_id' => $id_post,                
                    'reference_stock' => $code, 
                    'date_created' => date('Y-m-d H:i:s'), 
                    'user_id' => $this->session->userdata['user_id'], 
                    'stock_virtuelle' => $quantite, 
                    'stock_actuelle' => 0, 
                );
                $this->mdl_stockmvt->create($data_stockmvt);
            }
           /* $data = array(
                'virtual_stock' => $restant, 
            );
            $this->db->where('ref_stock', trim($code));
            $this->db->update('ip_stock', $data); */          
           /* $querytot = $this->mdl_stock->where('ref_stock', trim($code)); 
            $querytot = $this->mdl_stock->get()->result();*/

            $querytot = $this->mdl_stockmvt->where('reference_stock', trim($code)); 
            $querytot = $this->mdl_stockmvt->get()->result();  
            if($querytot[0]->sumstckvirt>0){
                $restant_tot = $querytot[0]->quantite_stock-$querytot[0]->sumstckvirt;
            }else{
                $restant_tot = $querytot[0]->quantite_stock+$querytot[0]->sumstckvirt;
            } 
           // $restant_tot=  $querytot[0]->quantite_stock-$querytot[0]->sumstckvirt;
            if( $restant_tot < $querytot[0]->stock){ 
                $subject = "Alert stock produit";
                $message = "<html>
                <body><div style='color:#999 ;font-size:35px;' > <label> <center> BONJOUR,  </center></label></div><br> <div style='margin-left:40px ;padding:30px;border:1px solid rgba(153, 153, 153, 0.50);' > <div style='color:#333 ;'>" .  trim($code) . " EST PRESQUE EN RUPTURE DE STOCK.  <br> <br>  Le stock restant est maintenant inférieur au minimum de <b>" . $querytot[0]->stock . " </b>   <br> <br> Stock restant <b>: " . $restant_tot . "</b><br> <br>Nous vous conseillons de vous rendre sur la page produit afin de renouveler vos stocks. </div></div></body>
                </html> ";
                $array = [];
                
               phpmail_send($from, $to, $subject, $message, $array);

            }

        }else{
            if (count($query) > 0) {
            $restant = $query[0]->actual_stock + $quantite;
            }
           /* $data = array(
                'actual_stock' => $restant, 
            );
        
            $this->db->where('ref_stock', trim($code));
            $this->db->update('ip_stock', $data);*/
            if($quantite!=0){
                $data_stockmvt = array(
                    'module' => $module, 
                    'module_id' => $id_post,                
                    'reference_stock' => $code, 
                    'date_created' => date('Y-m-d H:i:s'), 
                    'user_id' => $this->session->userdata['user_id'], 
                    'stock_virtuelle' => 0,
                    'stock_actuelle' => $quantite, 
                );
                $this->mdl_stockmvt->create($data_stockmvt);
            }
           /* $querytot = $this->mdl_stock->where('ref_stock', trim($code)); 
            $querytot = $this->mdl_stock->get()->result();
            $restant_tot=  $querytot[0]->quantite_stock-$querytot[0]->actual_stock;*/

            $querytot = $this->mdl_stockmvt->where('reference_stock', trim($code)); 
            $querytot = $this->mdl_stockmvt->get()->result();
            if($querytot[0]->sumstckactuel>0){
                $restant_tot = $querytot[0]->quantite_stock-$querytot[0]->sumstckactuel;
            }else{
                $restant_tot = $querytot[0]->quantite_stock+$querytot[0]->sumstckactuel;
            }
         //   $restant_tot=  $querytot[0]->quantite_stock-abs($querytot[0]->sumstckactuel); 
            if( $restant_tot < $querytot[0]->stock){
                $subject = "Alert stock produit";
                $message = "<html>
                <body><div style='color:#999 ;font-size:35px;' > <label> <center> BONJOUR,  </center></label></div><br> <div style='margin-left:40px ;padding:30px;border:1px solid rgba(153, 153, 153, 0.50);' > <div style='color:#333 ;'>" .  trim($code) . " EST PRESQUE EN RUPTURE DE STOCK.  <br> <br>  Le stock restant est maintenant inférieur au minimum de <b>" . $querytot[0]->stock . " </b>   <br> <br> Stock restant <b>: " . $restant_tot . "</b><br> <br>Nous vous conseillons de vous rendre sur la page produit afin de renouveler vos stocks. </div></div></body>
                </html> ";
                $array = [];
                
               phpmail_send($from, $to, $subject, $message, $array);

            }
        }
    }
}