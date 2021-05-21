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

class Mdl_Products extends Response_Model
{

    public $table = 'ip_products';
    public $primary_key = 'ip_products.product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_families.family_name, ip_products.product_name');
    }

    public function default_join()
    {
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
       // $this->db->join('ip_file_product', 'ip_file_product.id_poduct = ip_products.product_id', 'left');
        //$this->db->join('ip_prix_ventes', 'ip_prix_ventes.id_products = ip_products.product_id', 'left');
    }

    public function by_product($match,$langue)
    {
        $this->db->like('product_sku', $match);
        if($langue=="Arabic"){
            $this->db->or_like('product_name_ar', $match);
            $this->db->or_like('product_description_ar', $match);
        }elseif($langue=="English"){
            $this->db->or_like('product_name_en', $match);
            $this->db->or_like('product_description_eng', $match);
        }else{
            $this->db->or_like('product_name', $match);
            $this->db->or_like('product_description', $match);
        }
       
    }

   

    public function by_family($match)
    {
        $this->db->where('ip_products.family_id', $match);
    }

    public function filter_product($filter_family, $filter_product)
    {

        $where = "((LOWER(product_sku) LIKE '%" . $filter_product . "%' )";
        $where .= " OR (LOWER(product_name) LIKE '%" . $filter_product . "%' )";
        $where .= " OR (LOWER(product_description) LIKE '%" . $filter_product . "%' )";
        $where .= " )";
        $where .= " AND (ip_products.family_id = $filter_family)";
        $this->db->WHERE("$where");
    }

    public function validation_rules()
    {  
      //  var_dump($this->input->post('product_sku'));//die('1');
        $product_sku_res = trim($this->input->post('product_sku'));
        $this->db->where("trim(product_sku)", $product_sku_res);    
        $ip_products = $this->db->get("ip_products")->result();
        $product_sku = 'required';

        if (!empty($ip_products)) {           
            foreach ($ip_products as $ip_product) {              
                if (trim($ip_product->product_sku) == $product_sku_res && $ip_product->product_id != $this->uri->segment(3)) {
                    $product_sku = 'required|is_unique[ip_products.product_sku]';
                }                
            }
        }

        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => lang('product_sku'),
                'rules' => $product_sku,
            ),
            'marge' => array(
                'field' => 'marge',
                'label' => lang('marge'),
                'rules' => '',
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => lang('product_name'),
                'rules' => '',
            ),
            'product_name_en' => array(
                'field' => 'product_name_en',
                'label' => lang('product_name'),
                'rules' => '',
            ),
            'product_name_ar' => array(
                'field' => 'product_name_ar',
                'label' => lang('product_name'),
                'rules' => '',
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => lang('product_description'),
                //'rules' => 'required',
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => lang('product_price'),
                'rules' => '',
            ),
            'purchase_price' => array(
                'field' => 'purchase_price',
                'label' => lang('purchase_price'),
                'rules' => '',
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => lang('family'),
                'rules' => 'required',
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => lang('tax_rate'),
                'rules' => ' ',
            ),
            'remise' => array(
                'field' => 'Remise',
                'label' => lang('product_price'),
                'rules' => '',
            ),           
            'code_barre' => array(
                'field' => 'code_barre',
                'label' => 'Code_barre',
                'rules' => '',
            ),
            'approvisionnement' => array(
                'field' => 'approvisionnement',
                'label' => 'approvisionnement',
                'rules' => '',
            ),            
            'fournisseur_id' => array(
                'field' => 'Fournisseur',
                'label' => 'Fournisseur',
                'rules' => '',
            ),
            'poids' => array(
                'field' => 'poids',
                'label' => 'Poids',
                'rules' => '',
            ),
            'marque' => array(
                'field' => 'marque',
                'label' => 'Marque',
                'rules' => '',
            ),
            'stock' => array(
                'field' => 'stock',
                'label' => 'Stock',
                'rules' => '',
            ),
            'quantite' => array(
                'field' => 'quantite',
                'label' => 'Quantité',
                'rules' => '',
            ),
            'unite_id' => array(
                'field' => 'unite',
                'label' => 'Unité',
                'rules' => '',
            ),
            'prod_service' => array(
                'field' => 'prod_service',
                'label' => 'Prod_service',
                'rules' => '',
            ),
            'dlc' => array(
                'field' => 'dlc',
                'label' => 'dlc',
                'rules' => '',
            ),
            'langue' => array(
                'field' => 'langue',
                'label' => 'langue',
                'rules' => 'required',
            ),
            'product_description_eng' =>array(
                'field' => 'product_description_eng',
                'label' => 'product_description_eng',
            ),
            'product_description_ar' =>array(
                'field' => 'product_description_ar',
                'label' => 'product_description_ar',
            )
        );
    }

    public function create($db_array = null)
    {

        $product_id = parent::save(null, $db_array);

        // Create an quote amount record

        return $product_id;
    }

    public function getPriceProduct($id_product, $id_devise)
    {
        $query = $this->db->where('id_products', $id_product);
        $query = $this->db->where('id_devise', $id_devise);
        $query = $this->db->get('ip_prix_ventes');
        return $query->result();
    }

    public function insertPriceProduct($data_prix_vent)
    {
        $this->db->insert('ip_prix_ventes', $data_prix_vent);
    }
    public function calculsomstock($code)
    {
       // $this->db->select('sum(ip_bl_items.item_quantity) as item_quantity');
        $this->db->select('ip_bl_items.item_quantity');
        $this->db->where('ip_bl_items.item_name', trim($code));
        $query = $this->db->get('ip_bl_items')->result();
        return ($query[0]->item_quantity);
    }
    public function calculstockalert($code,$qua,$etat,$res)
    {
        $this->db->select('ip_products.product_id,ip_products.stock,ip_products.quantite');
        $this->db->where('product_sku', trim($code));
        $this->db->where('prod_service', 0);
        $query = $this->db->get('ip_products')->result();
        $restant =0;
        // etat 0 : add (BL,Invoice..)
        if (count($query) > 0) {
            if($etat==0){
                $restant = $query[0]->quantite - $qua;
            }else{
                $restant = $query[0]->quantite + $res;
            }
           // $res = $this->calculsomstock($code);       
          
            $data = array(
                'quantite' => $restant, 
            );
            $this->db->where('product_id', $query[0]->product_id);
            $this->db->update('ip_products', $data);
             if(isset($query[0]->stock)){
                if (number_format(($restant), 2, '.', '') < number_format(($query[0]->stock), 2, '.', '')) {
                    $this->load->helper('mailer/phpmailer');
                    $this->load->helper('superadmin');
                    $settings = get_settings_superadmin();
                    $from = $settings['noreplay_mail'];
                    $to = $this->session->userdata['user_mail'];
                    $subject = "Alert stock produit";
                    $message = "<html>
                    <body><div style='color:#999 ;font-size:35px;' > <label> <center> BONJOUR,  </center></label></div><br> <div style='margin-left:40px ;padding:30px;border:1px solid rgba(153, 153, 153, 0.50);' > <div style='color:#333 ;'>" . $code . " EST PRESQUE EN RUPTURE DE STOCK.  <br> <br>  Le stock restant est maintenant inférieur au minimum de <b>" . $query[0]->stock . " </b>   <br> <br> Stock restant <b>: " . $restant . "</b><br> <br>Nous vous conseillons de vous rendre sur la page produit afin de renouveler vos stocks. </div></div></body>
                    </html> ";
                    $array = [];
                    
                   phpmail_send($from, $to, $subject, $message, $array);
                
                }
            }
       }
    }

    public function by_file($match)
    {
        $this->db->like('product_sku', $match);
        $this->db->select('ip_products.product_id');
        $querys = $this->db->get('ip_products')->result();
        $this->db->select('ip_file_product.id_poduct,ip_file_product.name_file');        
        $this->db->where('ip_file_product.id_poduct', $querys[0]->product_id);
        $query = $this->db->get('ip_file_product')->result();
        return ($query[0]);
    }
    public function by_langue($id,$langue)
    {
        //$this->by_file()
        $this->db->where('ip_products.product_id',$id);
       // return var_dump($langue);
        if($langue == 'Arabic'){    
           $this->db->select('ip_products.product_description_ar as product_description,ip_products.product_name_ar as product_name');              
           $this->db->where('ip_products.product_name_ar is NOT NULL ', NULL, FALSE);  
           $this->db->where('ip_products.product_description_ar is NOT NULL ', NULL, FALSE);  

        }
        if($langue == 'English'){
            $this->db->select('ip_products.product_description_eng as product_description,ip_products.product_name_en as product_name');              
          //  $this->db->->where('ip_products.product_name_en'' != \'\'');
            $this->db->where('ip_products.product_name_en is NOT NULL ', NULL, FALSE);     
            $this->db->where('ip_products.product_description_eng is NOT NULL ', NULL, FALSE);           
        }
        if($langue == 'French'){
            $this->db->select('ip_products.product_description as product_description,ip_products.product_name as product_name');              
            $this->db->where('ip_products.product_name is NOT NULL ', NULL, FALSE);  
            $this->db->where('ip_products.product_description is NOT NULL ', NULL, FALSE);            
        }
        
        $querys = $this->db->get('ip_products')->result();
        return $querys;
       
        
    }

    public function getDescription($match,$langue)
    {
        
       // $this->db->like('product_sku',$match);
        $this->db->where('product_sku',$match);
       // $this->db->select('ip_products.product_id');
        if($langue=='Arabic'){
            $this->db->select('ip_products.product_description_ar as description ');    
        }elseif($langue=='English'){
            $this->db->select('ip_products.product_description_eng as description');   
        }elseif($langue=='French'){
            $this->db->select('ip_products.product_description as description');   
        }
        $querys = $this->db->get('ip_products')->result();
       if(count($querys)>0){
            return ($querys[0]);
        }else{
            return ('none');
        } 
       // if(count($querys)>0)
           
       // $this->db->where('ip_file_product.id_poduct', $querys[0]->product_id);
      //  $query = $this->db->get('ip_file_product')->result();
      //  return (count($querys));
    }

    public function getSotock($product_sku){
        $query = $this->db->query("SELECT ip_stock.*,ip_products.*,ip_products_mvtstock.*,SUM(ip_products_mvtstock.stock_actuelle) as sumstock_actuelle,SUM(ip_products_mvtstock.stock_virtuelle) as sumstock_virtuelle,ip_products_mvtstock.reference_stock FROM `ip_products_mvtstock`,`ip_products`,`ip_stock` WHERE ip_stock.ref_stock=ip_products_mvtstock.reference_stock and ip_stock.produit_id=ip_products.product_id and `reference_stock` LIKE '%$product_sku%' GROUP BY ip_products_mvtstock.reference_stock");
        $res = $query->result();
        return $res;
    }
}