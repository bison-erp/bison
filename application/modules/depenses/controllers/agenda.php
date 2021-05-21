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

class Agenda extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_depenses');
    }

    public function index()
    {

        //var_dump(json_encode($data));

        $this->layout->buffer('content', 'depenses/agenda');
        $this->layout->render();

    }

}