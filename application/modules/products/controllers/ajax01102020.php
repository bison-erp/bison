<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * FUNCTIONS LIST
 * modal_product_lookup()
 * partial_modal_product_lookup()
 * create()
 * modal_product_add()
 * process_product_selection()
 * name_product_query()
 * product_detail_query()
 * price_devise()
 */

class Ajax extends Admin_Controller
{

    public function modal_product_lookup()
    {
        $filter_family = $this->input->get('filter_family');
        $filter_product = $this->input->get('filter_product');
        $devise = $this->input->post('devise');
        $type_doc = $this->input->post('type_doc');
        $langue = $this->input->post('langue');
        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('prix_ventes/mdl_prix_ventes');

        // Apply filters

        if ((int) $filter_family) {
            $products = $this->mdl_products->by_family($filter_family);
        }
        if (!empty($filter_product)) {
            $products = $this->mdl_products->by_product($filter_product,$langue);
        }              
        $products = $this->mdl_products->get();
        $products = $this->mdl_products->result();

        $i = 0;
        foreach ($products as $product) {
            $product_price = $product->product_price;
            $tax_id = $product->tax_rate_id;

            $query_prix = $this->mdl_prix_ventes->where('id_devise', $devise);
            $query_prix = $this->mdl_prix_ventes->where('id_products', $product->product_id);
            $query_prix = $this->mdl_prix_ventes->get()->result();
            if (count($query_prix)) {
                $product_price = $query_prix[0]->prix_vente;
                $tax_id = $query_prix[0]->id_tax;
            }

            $products[$i]->product_price_dev = $product_price;
            $i = $i + 1;
        }

        $families = $this->mdl_families->get()->result();

        $data = array(
            'products' => $products,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'devise' => $devise,
            'type_doc' => $type_doc,   
            'langue'  => $langue        
        );

        $this->layout->load_view('products/modal_product_lookup', $data);
    }

    public function partial_modal_product_lookup()
    {
        $filter_family = $this->input->get('filter_family');
        $filter_product = $this->input->get('filter_product');
        $devise = $this->input->get('devise');
        $langue = $this->input->get('langue');
        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('prix_ventes/mdl_prix_ventes');

        // Apply filters

        if (((int) $filter_family) && (!empty($filter_product))) {
            $products = $this->mdl_products->filter_product($filter_family, $filter_product);
        } else {
            if ((int) $filter_family) {
                $products = $this->mdl_products->by_family($filter_family);
            }

            if (!empty($filter_product)) {
                $products = $this->mdl_products->by_product($filter_product,$langue);
            }
        }
       // $this->db->where('ip_products.langue', $langue);
        $products = $this->mdl_products->get();
        $products = $this->mdl_products->result();

        $i = 0;
        foreach ($products as $product) {
            $product_price = $product->product_price;
            $tax_id = $product->tax_rate_id;

            $query_prix = $this->mdl_prix_ventes->where('id_devise', $devise);
            $query_prix = $this->mdl_prix_ventes->where('id_products', $product->product_id);
            $query_prix = $this->mdl_prix_ventes->get()->result();
            if (count($query_prix)) {
                $product_price = $query_prix[0]->prix_vente;
                $tax_id = $query_prix[0]->id_tax;
            }

            $products[$i]->product_price_dev = $product_price;
            $i = $i + 1;
        }
        $families = $this->mdl_families->get()->result();
        $data = array(
            'products' => $products,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'devise' => $devise,
            'langue' => $langue,
        );

        $this->layout->load_view('products/partial_modal_product_lookup', $data);
    }

    public function create()
    {
        $this->load->model('products/mdl_products');
        $this->load->model('prix_ventes/mdl_prix_ventes');

        if ($this->mdl_products->run_validation()) {
            $user_id = $this->session->userdata['user_id'];
            $db_array = array(
                'family_id' => $this->input->post('family_id'),
                'product_name' => $this->input->post('product_name'),
                'product_description' => $this->input->post('product_description'),
                'product_description_eng' => $this->input->post('product_description_eng'),
                'product_description_ar' => $this->input->post('product_description_ar'),
                'product_sku' => $this->input->post('product_sku'),
                'product_price' => $this->input->post('product_price'),
                'purchase_price' => $this->input->post('purchase_price'),
                'tax_rate_id' => $this->input->post('tax_rate_id'),
                'prod_service' => $this->input->post('prod_service'),               
                'poids' => $this->input->post('poids'),
                'quantite' => $this->input->post('quantite'),
                'code_barre' => $this->input->post('code_barre'),
                'marque' => $this->input->post('marque'),
                'stock' => $this->input->post('stock'),
                'unite_id' => $this->input->post('unite_id'),
                'langue' => $this->input->post('langue'),
                'user_id' => $user_id,
                'product_name_en' => $this->input->post('product_name_en'),
                'product_name_ar' => $this->input->post('product_name_ar'),
            );
          //  return var_dump($db_array);die('1');
            $product_id = $this->mdl_products->create($db_array);
            $config = array();
            $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct';
            if (!is_dir($dir_path)) {
                mkdir($dir_path, 0777);
            }
            $idprod = $this->db->insert_id();
            //  return die('hh' . var_dump($idprod));
            /*  $var = $this->input->post('images');
            // return die('hh' . var_dump($var));
            if (!empty($var)) {
            for ($i = 0; $i < count($this->input->post('images')); $i++) {
            $expl = explode("o//o", $this->input->post('images')[$i]);

            $data = array(
            'id_poduct' => $idprod,
            'name_file' => $expl[0],
            'service_client' => $this->input->post('prod_service'),
            );
            $this->db->insert('ip_file_product', $data);
            $_FILES['file']['name'] = $expl[0];

            $_FILES['file']['type'] = $expl[2];

            $_FILES['file']['size'] = $expl[1];

            $_FILES['file']['temp'] = $expl[3];

            $config['upload_path'] = $dir_path;

            $config['allowed_types'] = 'jpg|jpeg|png|gif';

            $config['max_size'] = '1024000';

            $config['overwrite'] = true;
            move_uploaded_file($_FILES['file']['temp'], "$dir_path/$name");
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
            $this->upload->data();
            }

            }
            }
             */
            // $product_id = $this->mdl_products->save();

            $prx_devise = $this->input->post('prx_devise');
            $prx_price = $this->input->post('prx_price');
            $prx_tax = $this->input->post('prx_tax');

            foreach ($prx_devise as $key => $value) {
                if ($prx_price[$key] != '') {
                    $data_prix_vent = array(
                        'id_products' => $product_id,
                        'prix_vente' => $prx_price[$key],
                        'id_devise' => $prx_devise[$key],
                        'id_tax' => $prx_tax[$key],
                        'etat' => 1,
                    );

                    $this->mdl_products->insertPriceProduct($data_prix_vent);
                }
                if ($prx_devise[$key] == 1) {
                    $prx = $prx_price[$key];
                }
            }
            $datap = array(
                'product_price' => $prx,
            );

            $this->db->where('product_id', $product_id);
            $this->db->update('ip_products', $datap);

            $response = array(
                'success' => 1,
                'product_id' => $product_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors(),
            );
        }

        echo json_encode($response);
    }

    public function modal_product_add()
    {
        $this->load->model('devises/mdl_devises');
        $this->load->model('mdl_products');

        if ($this->input->post('btn_cancel')) {
            redirect('products/modal_product_lookup/11');
        }

        $this->load->model('families/mdl_families');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('unite/mdl_unite');

        $type_doc = $this->input->post('type_doc');
        $this->load->model('settings/mdl_settings');
        $typetaxe = $this->mdl_settings->gettypetaxeinvoice();

        //  return var_dump($restaxe);
        $data = array(
            'families' => $this->mdl_families->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'devises' => $this->mdl_devises->get()->result(),
            'type_doc' => $type_doc,
            'unite' => $this->mdl_unite->get()->result(),
            'gestionstock' => gestionstock(),
            'typetaxe ' => $typetaxe,
            'default_language_document'=>$this->mdl_settings->setting('default_language_document')
        );
        $this->layout->load_view('products/modal_product_add', $data);
    }

    public function process_product_selection()
    {
        $this->load->model('mdl_products');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('prix_ventes/mdl_prix_ventes');

        $devise_symbole = $this->input->post('devise_symbole');
        $devise = $this->input->post('devise');
        
        $products = $this->mdl_products->where_in('product_id', $this->input->post('product_ids'))->get()->result();
        $i = 0;
       
 foreach ($products as $product) {
            $product_price = $product->product_price;
            $tax_id = $product->tax_rate_id;

            $query_prix = $this->mdl_prix_ventes->where('id_devise', $devise);
            $query_prix = $this->mdl_prix_ventes->where('id_products', $product->product_id);
            $query_prix = $this->mdl_prix_ventes->get()->result();
            if (count($query_prix)) {
                $product_price = $query_prix[0]->prix_vente;
                $tax_id = $query_prix[0]->id_tax;
            }

            $query_tax = $this->mdl_tax_rates->where('tax_rate_id', $tax_id);
            $query_tax = $this->mdl_tax_rates->get()->result();
            $montantTVA = (double) $product_price * (double) $query_tax[0]->tax_rate_percent / 100;

            $montantTotal = $montantTVA + (double) $product_price;
            $products[$i]->montantTVA = format_devise($montantTVA, $devise, 0);
            $products[$i]->product_price_format = format_devise($product_price, $devise, 0);
            $products[$i]->product_price_dev = $product_price;

            $products[$i]->tax_rate_id_dev = $tax_id;
           // $products[$i]->tax_rate_id_dev = $tax_id;
            $products[$i]->montantTVATotal = format_devise($montantTotal, $devise, 0);

            $product->product_price = format_amount($product->product_price);
           
            $product->id_poduct = $product->id_poduct;
            $product->name_file = $product->name_file;
            $i = $i + 1;
        }
       
        echo json_encode($products);
    }

    public function name_product_query()
    {
        // Load the model
        $this->load->model('mdl_products');

        // Get the post input
        $query = $this->input->post('query');

        $products = $this->mdl_products->select('product_name, product_sku')->like('product_sku', $query)->order_by('product_name')->get(array(), false)->result();

        $response = array();

        foreach ($products as $product) {
            $response[] = $product->product_sku;
        }

        echo json_encode($response);
    }

    public function product_detail_query()
    {
        // Load the model
        $this->load->model('mdl_products');
        $this->load->model('prix_ventes/mdl_prix_ventes');
        $this->load->model('tax_rates/mdl_tax_rates');

        // Get the post input
        $query = $this->input->post('query');
        $devise_symbole = $this->input->post('devise_symbole');
        $devise = $this->input->post('devise');

        $products = $this->mdl_products->select('product_id, product_sku, product_name, product_description, product_price, tax_rate_id, family_id')->like('product_sku', $query)->order_by('product_name')->get(array(), false)->result();
        $tax = $this->mdl_tax_rates->get()->result();
        $response = array();
        // print_r($products[0]);
        foreach ($products as $product) {
            $this->db->where('id_products', $product->product_id);
            $this->db->where('id_devise', $devise);
            $prix_ventes = $this->mdl_prix_ventes->get()->result();
            //print_r($prix_ventes);
            //            echo '<br>';
            //echo  count($prix_ventes);
            if (count($prix_ventes) > 0) {
                foreach ($prix_ventes as $valuep) {
                    //print_r($valuep);
                    $p_tva = $valuep->prix_vente * $valuep->tax_rate_percent / 100;
                    $p_tot = $p_tva + (double) $valuep->prix_vente;
                    $montantTVA = $p_tva;

                    $montantTotal = $p_tot;

                    $product->product_price = ($valuep->prix_vente);

                    $response['product_id'] = $valuep->product_id;
                    $response['product_name'] = $valuep->product_name;
                    $response['product_code'] = $valuep->product_sku;
                    $response['product_description'] = $valuep->product_description;
                    $response['product_price'] = format_amount($valuep->prix_vente);
                    $response['tax_rate_id'] = $valuep->id_tax;

                    $response['montantTVA'] = format_devise($montantTVA, $devise);
                    $response['product_price_format'] = format_devise($valuep->prix_vente, $devise);

                    $response['montantTVATotal'] = format_devise($montantTotal, $devise);
                    $response['family_id'] = $valuep->family_id;
                }
            } else {
                foreach ($tax as $value) {
                    if ($value->tax_rate_id == $product->tax_rate_id) {
                        $taxx = $value->tax_rate_percent;
                    }
                }
                $montantTVA = $taxx * $product->product_price / 100;

                $montantTotal = $montantTVA + $product->product_price;

                $product->product_price = ($product->product_price);

                $response['product_id'] = $product->product_id;
                $response['product_name'] = $product->product_name;
                $response['product_code'] = $product->product_sku;
                $response['product_description'] = $product->product_description;
                $response['product_price'] = format_amount($product->product_price);
                $response['tax_rate_id'] = $product->tax_rate_id;

                $response['montantTVA'] = format_devise($montantTVA, $devise);
                $response['product_price_format'] = format_devise($product->product_price, $devise);

                $response['montantTVATotal'] = format_devise($montantTotal, $devise);
                $response['family_id'] = $product->family_id;
            }
        }

        //recup prix selon devise
        //print_r($prix_ventes);die;

        echo json_encode($response);
    }

    public function price_devise()
    {

        // Load the model
        $this->load->model('mdl_products');
        $id_product = $this->input->post('id_product');
        $id_devise = $this->input->post('id_devise');
        $price = $this->mdl_products->getPriceProduct($id_product, $id_devise);
        if (count($price) != 0) {
            $returned = $price[0]->prix_vente;
        } else {
            $returned = 0;
        }

        echo json_encode($returned);
    }

    public function load_products_partial_filter()
    {

        $filter_family = $this->input->post('filter_family');
        $filter_products = trim(strtolower($this->input->post('filter_products')));

        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
        if ($filter_products != "") {
            $where = "((LOWER(ip_products.product_sku) LIKE '%" . $filter_products . "%') ";

            $where .= " OR (LOWER(ip_products.product_name) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_products.product_description) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_products.product_name_en) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_products.product_description_eng) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_products.product_name_ar) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_products.product_description_ar) LIKE '%" . $filter_products . "%' )";
            $where .= " OR (LOWER(ip_families.family_name) LIKE '%" . $filter_products . "%' )";

            $where .= " )";
        } else {
            $where = "ip_products.product_id <> 0";
        }
        if ($filter_family != "all") {
            $where .= " AND (ip_products.family_id = $filter_family)";
        }

        $this->db->WHERE("$where");
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_products');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $products = $this->db->get("ip_products")->result();
        $this->load->model('settings/mdl_settings');
        $data = array(
            'products' => $products,
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'typetaxe' => $this->mdl_settings->gettypetaxeinvoice(),
        );
        $this->layout->load_view('products/partial_product_table', $data);

//        echo "<tr><td colspan='8' style='white-space: initial;'>";
        //        print_r($_POST);
        //
        //        echo "</td></tr>";
    }

    public function getProductid()
    {
        $id = $this->input->post('id');

       // $this->db->select(array('family_name', 'product_sku', 'product_name', 'product_description', 'product_price'));
        $this->db->WHERE('product_id', $id);
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $prodid = $this->db->get('ip_products')->result();
        echo json_encode($prodid);
    }

}