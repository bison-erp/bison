<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 * 
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * 
 */

class Quote_Rappel extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mdl_quote_rappel');
    }

    public function index($page = 0) {
        $this->load->model('mdl_quote_rappel');
        $response = $this->mdl_quote_rappel->selectRappelAujourdui();
        $this->layout->set(array('rappels' => $response));
        $this->layout->buffer('content', 'quote_rappel/index');
        $this->layout->render();
    }

    public function corn($page = 0) {
        $this->load->model('mdl_quote_rappel');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('email_templates/mdl_email_templates');
        
        $response = $this->mdl_quote_rappel->selectRappelAujourdui();

        $quotes = $this->mdl_quotes->get()->result();
        $model = $this->mdl_email_templates->where('email_template_id',3)->get()->result();
        
        $this->layout->set(
                array(
                    'rappels' => $response,
                    'model' => $model,                    
                    'quotes' => $quotes
                )
                );
        $this->layout->buffer('content', 'quote_rappel/corn');
        $this->layout->render();
    }
    
        public function historique_relances($page = 0) {
        $this->load->model('mdl_quote_rappel');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('email_templates/mdl_email_templates');
        $response = $this->mdl_quote_rappel->selectRappel();

        $quotes = $this->mdl_quotes->get()->result();
        $model = $this->mdl_email_templates->where('email_template_id',3)->get()->result();
        $this->layout->set(
                array(
                    'rappels' => $response,
                    'model' => $model,
                    'quotes' => $quotes
                )
                );
        $this->layout->buffer('content', 'quote_rappel/historique_relances');
        $this->layout->render();
    }

    public function form($id = NULL) {
        
    }

    public function delete($id) {
        
    }

}
