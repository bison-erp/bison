<?php

/**
 * @author  Oussema
 * @date     24th Janvier, 2020
 * Description of cronnvoicerecurrente
 */
class cronnvoicerecurrente extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
      
    }

    public function createinvoice()
    {

        for ($i = 0; $i < count($this->get_list_abonnees()); $i++) {
          
            $this->getAllrappel($this->get_list_abonnees()[$i]->database);
        }
    }

    public function getAllrappel($db)
    {  
          
        $datenow = date('Y-m-d');
    
        $this->load->model('settings/mdl_settings');
        $this->load->model('invoices/mdl_invoices_recur');
        $this->db->join($db.'.ip_invoice_recur', 'ip_invoices.invoice_id = ip_invoice_recur.id_invoice');
        $this->db->join($db.'.ip_invoice_amounts', 'ip_invoices.invoice_id = ip_invoice_amounts.invoice_id');
        $this->db->select('ip_invoice_amounts.*,ip_invoices.*,DATEDIFF("'.$datenow.'" ,date_next ) AS TOTAL_DATE');
        $ip_invoices_recurring = $this->db->get($db.'.ip_invoices')->result();
         $arrayres=array();
         foreach($ip_invoices_recurring  as $key){
          if($key->TOTAL_DATE==0){               
            $arrayres[]=$key;
           }
        }
     
          if(count($arrayres)>0){     
          
             for($i=0;$i<count($arrayres);$i++){
                $datarecur=array('id_invoice'=>$arrayres[$i]->invoice_id,'date_creation'=> date('Y-m-d'),'id_user'=>$arrayres[$i]->user_id,'date_next'=>$this->mdl_invoices_recur->nextdate(date('Y-m-d'),$arrayres[$i]->recursive_id));

                $valCode_invoice = $this->getNextCodeFacture($arrayres[$i]->invoice_number,$db);
             
                    $data = array(
                        'user_id' => $arrayres[$i]->user_id,
                        'invoice_delai_paiement' => $arrayres[$i]->invoice_delai_paiement,
                        'client_id' =>$arrayres[$i]->client_id,
                        'nature' => $arrayres[$i]->nature,
                        'invoice_password' => $arrayres[$i]->invoice_password,
                        'invoice_date_created' => date('Y-m-d'),
                        'invoice_time_created' => date('H:i:s'),
                        'invoice_date_due' => $this->next_invoices_due_after($db,$arrayres[$i]->invoice_date_created,$arrayres[$i]->invoice_date_due),                       
                        'invoice_number' => $valCode_invoice,
                        'invoice_terms' => $arrayres[$i]->invoice_terms,
                        'invoice_status_id' => $arrayres[$i]->invoice_status_id,
                        'document' =>$arrayres[$i]->document,
                        'joindredevis' => $arrayres[$i]->joindredevis,                      
                        'bl_id' => $arrayres[$i]->bl_id,
                        'avoir' => $arrayres[$i]->avoir,
                        'quote_date_accepte' => $arrayres[$i]->quote_date_accepte,
                        'creditinvoice_parent_id' => $arrayres[$i]->creditinvoice_parent_id,
                        'payment_method' => $arrayres[$i]->payment_method,
                        'invoice_url_key' => $arrayres[$i]->invoice_url_key,
                        'user_id_modif' => $arrayres[$i]->user_id_modif,
                        'invoice_date_modified' => $arrayres[$i]->invoice_date_modified,
                        'is_read_only' => $arrayres[$i]->is_read_only,
                        'invoice_group_id' => $arrayres[$i]->invoice_group_id,                                                           
                    );               
                     $this->db->insert($db.'.ip_invoices', $data);
                      $invoice_id = $this->db->insert_id(); 
                   
                      $data_ammount=array(
                        'invoice_id'=> $invoice_id,
                        'invoice_sign'=> $arrayres[$i]->invoice_sign,
                        'invoice_item_subtotal'=> $arrayres[$i]->invoice_item_subtotal,
                        'invoice_item_tax_total'=> $arrayres[$i]->invoice_item_tax_total,
                        'invoice_tax_total'=> $arrayres[$i]->invoice_tax_total,
                        'timbre_fiscale'=> $arrayres[$i]->timbre_fiscale,
                        'invoice_total'=> $arrayres[$i]->invoice_total,
                        'invoice_paid'=>$arrayres[$i]->invoice_paid,
                        'invoice_balance'=>$arrayres[$i]->invoice_balance,
                        'invoice_pourcent_remise'=>$arrayres[$i]->invoice_pourcent_remise,
                        'invoice_montant_remise'=>$arrayres[$i]->invoice_montant_remise,
                        'invoice_pourcent_acompte'=>$arrayres[$i]->invoice_pourcent_acompte,
                        'invoice_montant_acompte'=>$arrayres[$i]->invoice_montant_acompte,
                        'invoice_item_subtotal_final'=>$arrayres[$i]->invoice_item_subtotal_final,
                        'invoice_item_tax_total_final'=>$arrayres[$i]->invoice_item_tax_total_final,
                    );
                    $this->db->insert($db.'.ip_invoice_amounts', $data_ammount);
                    $this->db->WHERE("ip_invoices.invoice_id",$arrayres[$i]->invoice_id);
                    $this->db->join($db.'.ip_invoices', 'ip_invoice_items.invoice_id =ip_invoices.invoice_id');  
                    $this->db->join($db.'.ip_invoice_item_amounts', 'ip_invoice_item_amounts.item_id =ip_invoice_items.item_id');               
                    $ip_invoice_items_result = $this->db->get($db.'.ip_invoice_items')->result();  
                    for($j=0;$j<count($ip_invoice_items_result);$j++){
                        $data_itm = array(
                            'invoice_id' => $invoice_id,
                            'family_id' => $ip_invoice_items_result[$j]->family_id,
                            'item_tax_rate_id' =>$ip_invoice_items_result[$j]->item_tax_rate_id,
                            'item_date_added' => date('Y-m-j'),
                            'item_name' => $ip_invoice_items_result[$j]->item_name,
                            'item_description' => $ip_invoice_items_result[$j]->item_description,
                            'item_quantity' => $ip_invoice_items_result[$j]->item_quantity,
                            'item_price' => $ip_invoice_items_result[$j]->item_price,
                            'item_order' => $ip_invoice_items_result[$j]->item_order,
                            'item_code' => $ip_invoice_items_result[$j]->item_code,
                            'etat_champ' => $ip_invoice_items_result[$j]->etat_champ,
                        );
                        $this->db->insert($db.'.ip_invoice_items', $data_itm);
                        $item_id = $this->db->insert_id();       
                        $data_itm_am = array(
                            'item_id' => $item_id,
                            'item_subtotal' => $ip_invoice_items_result[$j]->item_subtotal,
                            'item_tax_total' =>$ip_invoice_items_result[$j]->item_tax_total,
                            'item_total' => $ip_invoice_items_result[$j]->item_total,
                        );                   
                        $this->db->insert($db.'.ip_invoice_item_amounts', $data_itm_am);
                    }

                    $this->deleterecur($arrayres[$i]->invoice_id,$db);
                    $this->saverecur($db,$datarecur);
                    $this->savesetting($db,$valCode_invoice);               
            }       
        }       
    }

   
    public function get_list_abonnees()
    {
        $ci = get_instance();
        $config_db['hostname'] = $ci->db->hostname;
        $config_db['username'] = $ci->db->username;
        $config_db['password'] = $ci->db->password;
        $config_db['dbdriver'] = $ci->db->dbdriver;
        $config_db['dbprefix'] = $ci->db->dbprefix;
        $config_db['pconnect'] = $ci->db->pconnect;
        $config_db['db_debug'] = $ci->db->db_debug;
        $config_db['cache_on'] = $ci->db->cache_on;
        $config_db['cachedir'] = $ci->db->cachedir;
        $config_db['char_set'] = $ci->db->char_set;
        $config_db['dbcollat'] = $ci->db->dbcollat;
        $config_db['swap_pre'] = $ci->db->swap_pre;
        $config_db['autoinit'] = $ci->db->autoinit;
        $config_db['stricton'] = $ci->db->stricton;

        $old_database = $ci->db->database;

        // LOAD DATABASE DES ABONNEES
        $config_db['database'] = $ci->db->database_orig;
        $config_db['database_orig'] = $ci->db->database_orig;
        $ci->db = $ci->load->database($config_db, true);

        $abonnees = $ci->db->get("ab_abonnes")->result();

        // LOAD DATABASE ORIGINE
        $config_db['database'] = $old_database;
        $ci->db = $ci->load->database($config_db, true);
        return $abonnees;
    }

    public function diffdate($expire){              
        $today_time = strtotime(date('Y-m-d'));        
        $expire_time = strtotime($expire);
        if(($today_time-$expire_time)>0){
            return false;
        }else{
            return true;
        }    
    }

    public function getNextCodeFacture($id,$db)
    {
        $this->load->model('settings/mdl_settings');     
        $this->db->where('invoice_number', $id);
        $invoice = $this->db->get($db.'.ip_invoices')->result();
        if (!empty($invoice)) {
            $id++;
            return $this->getNextCodeFacture($id,$db);
        } else {
            return $id;
        }
    }

    public function deleterecur($id,$db)
    {  
        $this->db->where('id_invoice', $id);
        $this->db->delete($db.'.ip_invoice_recur');
    }

    public function next_invoices_due_after($db,$date_debut,$date_fin){     
        /*$this->db->where('setting_key', 'invoices_due_after');
        $due_after = $this->db->get($db.'.ip_settings')->result();*/
        $date_debut_time = strtotime($date_debut);        
        $date_fin_time = strtotime($date_fin);
        $nbJours = abs($date_debut_time - $date_fin_time)/86400;
        return date('Y-m-d',strtotime('+'.$nbJours.' day'));     
    }

    public function saverecur($db,$data)
    {
        $this->db->insert($db.'.ip_invoice_recur', $data);
    }

    public function saveammountinvoice($db,$data)
    {
        $this->db->insert($db.'.ip_invoice_amounts', $data);
    }

    public function saveitemamount($db,$data_invoice_items,$data_invoice_item_amounts)
    {
        $this->db->insert($db.'.ip_invoice_items', $data_invoice_items);
        $invoice_items_id=$this->db->insert_id(); 
        $invoice_items_id_res = array('item_id' => $invoice_items_id);
        array_merge($data_invoice_item_amounts,$invoice_items_id_res);
        $this->db->insert($db.'.ip_invoice_item_amounts', $data_invoice_item_amounts);
    }

    public function savesetting($db,$valCode_invoice)
    {     
        $data=array('setting_value'=>$valCode_invoice);
        $this->db->where('setting_key','next_code_invoice');      
        $this->db->update($db.'.ip_settings', $data);
    }

  /*  public function diffbetweendate($datedebut,$expire){              
        $today_time = strtotime(date('Y-m-d'));        
        $expire_time = strtotime($expire);
        if(($today_time-$expire_time)>0){
            return false;
        }else{
            return true;
        }    
    }*/

}