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

class Products extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_products');
    }

    public function index($page = 0)
    { 
        $this->load->model('prix_ventes/mdl_prix_ventes');
        $this->load->model('families/mdl_families');
        $this->load->model('products/mdl_stockmvt');
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
            // $this->layout->set('products', $products);
            $this->layout->set(
                array(
                    'filter_placeholder' => lang('filter_products'),
                    'families' => $this->mdl_families->get()->result(),
                )
            );
            $this->layout->buffer('content', 'products/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form($id = null)
    {
        $sess_product_add = $this->session->userdata['product_add'];
        $this->load->model('productfile/mdl_productfile');  
        $this->load->model('attributs/mdl_option_attribut');
        if ($sess_product_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('products');
            }

            if ($this->mdl_products->run_validation()) {               
                $this->mdl_products->save($id);
                if ($id) {
                    $product_id = $id;
                    //  $this->db->where('id_poduct', $product_id);
                    //  $this->db->delete('ip_file_product');
                } else {
                    $product_id = $this->db->insert_id();
                }
                $user_id = $this->session->userdata['user_id'];
                $data = array(
                    'user_id' => $user_id,
                );

                $this->db->where('product_id', $product_id);
                $this->db->update('ip_products', $data);

                $config = array();
                $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct';
                if (!is_dir($dir_path)) {
                    mkdir($dir_path, 0777);
                }
                if (gestionstock() == true) {

                    if (count($_FILES['images']['name']) > 0 && strlen($_FILES['images']['name'][0])) {
                        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

                            $_FILES['file']['name'] = $_FILES['images']['name'][$i];

                            $_FILES['file']['type'] = $_FILES['images']['type'][$i];

                            $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];

                            $_FILES['file']['error'] = $_FILES['images']['error'][$i];

                            $_FILES['file']['size'] = $_FILES['images']['size'][$i];

                            $config['upload_path'] = $dir_path;

                            $config['allowed_types'] = 'jpg|jpeg|png|gif';

                            $config['max_size'] = '1024000';

                            $config['overwrite'] = true;
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('file')) {
                                $this->upload->data();
                            }
                           $name = str_replace(' ', '_', $_FILES['images']['name'][$i]);
                            $data = array(
                                'id_poduct' => $product_id,
                                'name_file' => $name,
                                'service_client' => $this->input->post('prod_service'),
                            );
                            $this->db->insert('ip_file_product', $data);
                        }}


                        if (count($_FILES['fiche']['name']) > 0 && strlen($_FILES['fiche']['name'][0])) {
                            for ($i = 0; $i < count($_FILES['fiche']['name']); $i++) {
    
                                $_FILES['file']['name'] = $_FILES['fiche']['name'][$i];
    
                                $_FILES['file']['type'] = $_FILES['fiche']['type'][$i];
    
                                $_FILES['file']['tmp_name'] = $_FILES['fiche']['tmp_name'][$i];
    
                                $_FILES['file']['error'] = $_FILES['fiche']['error'][$i];
    
                                $_FILES['file']['size'] = $_FILES['fiche']['size'][$i];
    
                                $config['upload_path'] = $dir_path;
    
                                $config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docx|pdf';
    
                                $config['max_size'] = '1024000';
    
                                $config['overwrite'] = true;
                                $this->load->library('upload', $config);
                                if ($this->upload->do_upload('file')) {
                                    $this->upload->data();
                                }
                               $name = str_replace(' ', '_', $_FILES['fiche']['name'][$i]);
                                $data = array(
                                    'produit_id' => $product_id,
                                    'name_file_fiche' => $name,                                  
                                );
                                $this->db->insert('ip_file_fiche', $data);
                            }}
                }


                // echo $product_id;
                $this->db->select('id_prix_ventes');
                $this->db->distinct();
                $this->db->from('ip_prix_ventes');
                $query = $this->db->where('id_products', $product_id)->get();
                $num = $query->num_rows();
                // echo $num;
                if ($num > 0) {
                    $this->db->where('id_products', $product_id);
                    $this->db->delete('ip_prix_ventes');
                }
                $prx = 0;
            
                foreach ($this->mdl_products->form_values['prx'] as $value) {

                    if ($value['product_price'] != '') {
                        $data_prix_vent = array(
                            'id_products' => $product_id,
                            'prix_vente' => $value['product_price'],
                            'id_devise' => $value['devise'],
                            'id_tax' => $value['tax_rate_id'],
                            'etat' => 1,
                        );
                        $this->db->insert('ip_prix_ventes', $data_prix_vent);
                        if ($value['devise'] == 1) {
                            $prx = $value['product_price'];
                        }
                    }
                }
          if($id){
          $this->db->where('product_id', $product_id);
          $this->db->delete('ip_tarif');

          $this->db->where('id_produit', $product_id);
          $this->db->delete('ip_declinaison');

          $this->db->where('produit_id', $product_id);
          $this->db->delete('ip_stock');

          $this->db->where('produit_id', $product_id);
          $this->db->delete('ip_deopt_stock');
          }

         // return var_dump($this->mdl_products->form_values['dec']);die('hh');
        //  $this->mdl_products->save($id); 
        $refstock=0;       
        foreach ($this->mdl_products->form_values['ref'] as $refvalue) { 
            $data_stock = array(
                'produit_id' => $product_id,
                'ref_stock' => $this->mdl_products->form_values['product_sku'].'/'.$refvalue,
                'quantite_stock' => $this->mdl_products->form_values['quantite_stock'][$refstock], 
                'prix_stock' =>  $this->mdl_products->form_values['prix'][$refstock], 
                'virtual_stock' =>  $this->mdl_products->form_values['virtual_stock'][$refstock], 
                'actual_stock' =>  $this->mdl_products->form_values['actual_stock'][$refstock],  
            );
            $this->db->insert('ip_stock', $data_stock);   
            $ip_stock_id = $this->db->insert_id();    
            foreach ($this->mdl_products->form_values['dec'.$refstock] as $value) { 
                list($group_option, $attributs) = split('[/.-]', $value);  
                if($attributs){                 
                    $data_declinaison = array(
                        'id_produit' => $product_id,
                        'id_group_option' => $group_option,
                        'id_attributs' => $attributs, 
                        'dec_stock_id' => $ip_stock_id, 
                    );
                    $this->db->insert('ip_declinaison', $data_declinaison);            
                }          
            }

            foreach ($this->mdl_products->form_values['depot'.$refstock] as $value) { 
                    $data_depot = array(                       
                        'stock_id' => $ip_stock_id,
                        'depot_id' => $value,
                        'produit_id'  => $product_id,                      
                    );
                    $this->db->insert('ip_deopt_stock', $data_depot);                      
            }

            $refstock++;
        }




              $qupu=0;
                foreach ($this->mdl_products->form_values['pricediff'] as $value) {                  
                        $data_tarif = array(
                            'product_id ' => $product_id,
                            'quantite_tarif' => $this->mdl_products->form_values['quantdiff'][$qupu],
                            'prix' => $value, 
                        );
                        $this->db->insert('ip_tarif', $data_tarif);  
                        $qupu++;                 
                }
                
                $datedlc= $this->mdl_products->form_values['dlc'];
                if ($datedlc != '') {
                    $datedlc = explode('/', $datedlc);
                    $datedlc = $datedlc[2] . '-' . $datedlc[1] . '-' . $datedlc[0];
                }  
                $datap = array(
                    'product_price' => $prx,
                    'dlc' => $datedlc,
                );

                $this->db->where('product_id', $product_id);
                $this->db->update('ip_products', $datap);
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    if (!$id) {
                        $data_log = array(
                            "log_action" => "add_product",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $product_id,
                            "log_field2" => $product_id,
                        );
                    } else {
                        $data_log = array(
                            "log_action" => "edit_product",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $product_id,
                            "log_field2" => $product_id,
                        );
                    }

                    $this->db->insert('ip_logs', $data_log);
                }
                redirect('products');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_products->prep_form($id)) {
                    show_404();
                }
            }

            $this->load->model('families/mdl_families');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('devises/mdl_devises');
            $this->load->model('prix_ventes/mdl_prix_ventes');
            $this->load->model('settings/mdl_settings');
            $this->load->model('fournisseurs/mdl_fournisseurs');
            $this->load->model('unite/mdl_unite');
            $this->load->model('depot/mdl_depot');
            $this->load->model('attributs/mdl_option_attribut');
            $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');
            $this->load->model('mdl_tarif');
            $this->load->model('mdl_file_fiche');
            $this->load->model('mdl_stock');
            $this->load->model('mdl_depot_stock');
            $this->load->model('mdl_declinaison');
            $ip_groupe_option = $this->db->get("ip_groupe_option")->result();   
          //  return var_dump($this->mdl_option_attribut->getAttribut(1));      
            $this->layout->set(
                array(
                    'families' => $this->mdl_families->get()->result(),
                    'fournisseur' => $this->mdl_fournisseurs->get()->result(),
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'devises' => $this->mdl_devises->get()->result(),
                    'prix_ventes' => $this->mdl_prix_ventes->where('id_products', $id)->get()->result(),
                    'typetaxe' => $this->mdl_settings->gettypetaxeinvoice(),
                    'unite' => $this->mdl_unite->get()->result(),
                    'file' => $this->mdl_productfile->where('id_poduct', $id)->get()->result(),
                    'gestionstock' => gestionstock(),
                    'depot' => $this->mdl_depot->get()->result(),
                    'attribut' => $this->mdl_option_attribut->get()->result(),
                    'groupe' => $ip_groupe_option,
                    'by_fournisseur'=>$this->mdl_fournisseurs->by_nom_fournisseur($this->mdl_products->form_value('id_fournisseur'))->get()->result(),
                    'by_categorie'=>$this->mdl_categorie_fournisseur->by_designation($this->mdl_products->form_value('categorie_id'))->get()->result(),
                    'by_family'=>$this->mdl_families->by_id_familie($this->mdl_products->form_value('family_id'))->get()->result(),
                    'tarif'=>  $this->mdl_tarif->where('ip_tarif.product_id', $id)->get()->result(),
                    'file_fiche'=>  $this->mdl_file_fiche->where('produit_id', $id)->get()->result(),
                    'stock'=>  $this->mdl_stock->where('produit_id', $id)->get()->result(),
                   
                    )
            );
            $this->layout->buffer('content', 'products/form');
            $this->layout->render();

        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id)
    {
        $sess_product_del = $this->session->userdata['product_del'];
        if ($sess_product_del == 1) {
            $this->mdl_products->delete($id);
            redirect('products');
        } else {
            redirect('sessions/login');
        }
    }
    public function deletefilproduct($id)
    {
        $this->load->model('productfile/mdl_productfile');
        $this->mdl_productfile->delete($id);

    }

    public function export_excel($ids = 0)
    {

        $cnt = 0;
        if($ids!='all'){
        $ids_array = explode("_", $ids);
            foreach ($ids_array as $client_id) {
                if ($cnt == 0) {
                    $this->db->where('ip_products.product_id', $client_id);
                } else {
                    $this->db->or_where('ip_products.product_id', $client_id);
                }
                $cnt++;
            }
        }
      
        //$this->db->select("ip_products.*,SUM(ip_invoice_amounts.invoice_balance) as 'solde',ip_devises.*");
        $this->db->group_by('ip_products.product_id');
      //  $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_clients.client_id', 'left');
       // $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_families', 'ip_products.family_id = ip_families.family_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');

        $products = $this->db->get("ip_products")->result();
        

        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()
            ->setCellValue('A1', 'Family')
            ->setCellValue('B1', 'Reference')
            ->setCellValue('C1', 'Product name')
            ->setCellValue('D1', 'Product description')
            ->setCellValue('E1', 'Purchase price')
            ->setCellValue('F1', 'Product price');
          //  ->setCellValue('G1', 'VAT');       
        $cnt2 = 2;
       
        $this->excel->getActiveSheet()->setTitle("Products list");
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFill()->getStartColor()->setARGB('FFDDDDDD');
//        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->applyFromArray(array('rgb' => '808080'));
        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);     
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
        foreach ($products as $product) {
            if($product->langue=="English"){
                $description = $product->product_description_eng;                
            }elseif($product->langue=="Arabic"){
                $description = $product->product_description_ar;                
            }else{
                $description =  $product->product_description;        
            }                      
            
           
            $this->excel->getActiveSheet()             
                ->setCellValue('A' . $cnt2, $product->family_name)
                ->setCellValue('B' . $cnt2, $product->product_sku)
                ->setCellValue('C' . $cnt2, $product->product_name)
                ->setCellValue('D' . $cnt2, $description)
                ->setCellValue('E' . $cnt2, format_devise($product->purchase_price, 1))
                ->setCellValue('F' . $cnt2, format_devise($product->product_price, 1))      
           //     ->setCellValue('G' . $cnt2, $product->tax_rate_name.'%')
            ;
            $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         //   $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $res = $this->mdl_products->getSotock($product->product_sku);
            /*
            $res = $this->mdl_products->getSotock($product->product_sku);
            //$cnt3= $this->excel->setActiveSheetIndex(0)->getHighestRow()+1;  
            $cnt3=$cnt2+1;
            $cnt4=$cnt3+1;  
            */
            $cnt4=1;
            if(count($res)>0){
                $cnt3=$cnt2+count($res);  
                $cnt4=$cnt3+1;  
                $this->excel->getActiveSheet()          
                ->setCellValue('B' . $cnt3, 'Réference produit')
                ->setCellValue('C' . $cnt3, 'Stock reelle')
                ->setCellValue('D' . $cnt3, 'Stock virtuelle')
                ->setCellValue('E' . $cnt3, 'Quantite sous produit ')
                ->setCellValue('F' . $cnt3, 'Reste');
                $this->excel->getActiveSheet()->getStyle('B' . $cnt3.':F'.$cnt3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $this->excel->getActiveSheet()->getStyle('B' . $cnt3.':F'.$cnt3)->getFill()->getStartColor()->setARGB('EFEAD7');
                $this->excel->getActiveSheet()->getStyle('A' . $cnt2.':F'.$cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                foreach($res as $resid){ 
                    
                    $reste=$resid->quantite_stock-$resid->sumstock_actuelle; 
                    $this->excel->getActiveSheet()             
                
                    ->setCellValue('B' . $cnt4, $resid->reference_stock)
                    ->setCellValue('C' . $cnt4, $resid->sumstock_actuelle)
                    ->setCellValue('D' . $cnt4, $resid->sumstock_virtuelle)
                    ->setCellValue('E' . $cnt4, $resid->quantite_stock)
                    ->setCellValue('F' . $cnt4, $reste);  

                    $this->excel->getActiveSheet()->getStyle('B' . $cnt4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C' . $cnt4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $cnt4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('E' . $cnt4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('F' . $cnt4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $cnt4++;
                } 
            } 
            $cnt2=$cnt2+$cnt4; 
           // $cnt2++; 
        }
        $filename = 'Products list.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }


    public function deletefile_fiche($id,$idprod)
    {
        $this->load->model('mdl_file_fiche');
        $sess_product_del = $this->session->userdata['product_del'];
        if ($sess_product_del == 1) {
            $this->mdl_file_fiche->delete($id);            
            redirect('products/form/'.$idprod.'#desc');
        } else {
            redirect('sessions/login');
        }
    }
}