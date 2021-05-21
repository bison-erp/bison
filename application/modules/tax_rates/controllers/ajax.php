<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Ajax extends Admin_Controller {

    public $ajax_controller = TRUE;

    public function getTaxRate() {
        $this->load->model('tax_rates/mdl_tax_rates');
        echo json_encode($this->mdl_tax_rates->get()->result());
    }

}
