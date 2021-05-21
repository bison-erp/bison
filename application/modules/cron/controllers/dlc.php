<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cron
 *
 * @author Oussema
 */
class dlc extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function existDB($db)
    {
        $this->db->where("SCHEMA_NAME", $db);
        $this->db->select("SCHEMA_NAME, count(SCHEMA_NAME) as count");
        $db_selected = $this->db->get("INFORMATION_SCHEMA.SCHEMATA")->result();
        return $db_selected[0]->count == 0 ? false : true;
    }

    public function calculdlc($db)
    {
	
        $sql = "SELECT * FROM ".$db.".ip_products,".$db.".ip_users WHERE ip_users.user_id=ip_products.user_id ";
        $result = $this->db->query($sql)->result();         
        return $result;
    }   
    public function cron_dlc()
    {
        $datenow = date('Y-m-d'); 
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $abonnees = get_list_abonnees();
        $settings = get_settings_superadmin();     
        $array = array(); 
        //if ($_SERVER["REMOTE_ADDR"] == $settings['ip_serveur']) {
            if ($_SERVER["SERVER_ADDR"] == $settings['ip_serveur']) {            
                foreach ($abonnees as $abonnee) { 
                    if ($this->existDB($abonnee->database)) { 
                    
                        $sql = "SELECT * FROM ".$abonnee->database.".ip_settings WHERE ip_settings.setting_key='limite_dlc'";
                        $result = $this->db->query($sql)->result(); 
                       // $message .= "<br>".$abonnee->database;      
                      // $cnt=count($this->calculdlc($abonnee->database)); 
                     // return var_dump($this->calculdlc($abonnee->database));
                      // $array[$jj][1]=$this->calculdlc($abonnee->database); 
                        if($this->calculdlc($abonnee->database)){
                            $arrayres=['key1'=>$result[0]->setting_value,'key2'=>$this->calculdlc($abonnee->database)];
                            array_push($array, $arrayres);                                
                        } 
                      /*  if($cnt>0){
                            
                            //return var_dump($cnt.'hh'.$abonnee->database);
                            foreach($this->calculdlc($abonnee->database) as $data){
                                if (isset($data->dlc)){
                                    if($data->dlc && $data->dlc!='0000-00-00' ){
                                    // return var_dump($data->dlc);
                                        $firstDate  = new DateTime($data->dlc);
                                        $secondDate = new DateTime($datenow);
                                        $intvl = $firstDate->diff($secondDate)->days;
                                        //echo $intvl.'db'.$abonnee->database.'hhh'.$result[0]->setting_value;
                                            if($intvl >= $result[0]->setting_value){
                                                 $message .= "<br>".$data->product_name.'db'.$abonnee->database; 
                                            } 
                                    };                                
                                }
                              // echo $cnt.$abonnee->database.'hhh';
                            
                                if($data->dlc && $data->dlc!='0000-00-00' && $cnt==1){
                                   // return var_dump('hh');  
                                    phpmail_send($from, 'oussema@novatis.tn', $subject, $message, $array);
                                };
                             
                            } 
                            $cnt=$cnt-1;
                        }*/

                    }
                } 
                $this->send($array);
               // return var_dump($array); 
            }
                      
    }

    public function send($obj){
        $settings = get_settings_superadmin();     
        $from = $settings['noreplay_mail'];
        $to = $settings['backup_mail'];        
        $subject = "DlC Produit ";             
        $datenow = date('Y-m-d'); 
        $array = array();
        $j=0;       
        while(count($obj)>0){
            $message="Liste des Produits expirées : <br>";
            $cntenu="";
            foreach($obj[$j]['key2'] as $data){ 
              $joursmoins=(int)$obj[$j]['key1'];           
                $resdata=$data;           
                    if (isset($resdata->dlc)){
                        if($resdata->dlc && $resdata->dlc!='0000-00-00' ){                      
                            $firstDate  = new DateTime($resdata->dlc);
                            $secondDate = new DateTime($datenow);
                            $intvl = $firstDate->diff($secondDate)->days;                           
                                if($intvl >= $joursmoins){ 
                                     $cntenu=  $resdata->product_name;
                                     $message .= "<br>" ; 
                                     $message .= $resdata->product_name; 
                                } 
                        };                                
                    }                        
            }           
            if(!empty($cntenu)){
                phpmail_send($from, 'oussema@novatis.tn', $subject, $message, $array);    
            }    
            unset($obj[$j]);  
           $j++;  
        }
        return;
    }
}