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

class Reports extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('reports/invoices_quotes');
    }

    public function rapport_annuel()
    {

        $devises = $this->db->get("ip_devises")->result();

        $this->layout->set(
            array(
                'devises' => $devises,
            )
        );
        $this->layout->buffer('content', 'reports/rapport_annuel');
        $this->layout->render();
    }

    public function rapport_mensuel()
    {

        $devises = $this->db->get("ip_devises")->result();

        $this->layout->set(
            array(
                'devises' => $devises,
            )
        );
        $this->layout->buffer('content', 'reports/rapport_mensuel');
        $this->layout->render();
    }

    public function rapport_clients()
    {

        $devises = $this->db->get("ip_devises")->result();

        $this->layout->set(
            array(
                'devises' => $devises,
            )
        );
        $this->layout->buffer('content', 'reports/rapport_clients');
        $this->layout->render();
    }

    public function rapport_products()
    {

        $devises = $this->db->get("ip_devises")->result();

        $this->layout->set(
            array(
                'devises' => $devises,
            )
        );
        $this->layout->buffer('content', 'reports/rapport_products');
        $this->layout->render();
    }

    public function rapport_commercials()
    {

        $devises = $this->db->get("ip_devises")->result();
        $groupes_users = $this->db->get("ip_groupes_users")->result();

        $this->layout->set(
            array(
                'devises' => $devises,
                'groupes_users' => $groupes_users,

            )
        );
        $this->layout->buffer('content', 'reports/rapport_commercials');
        $this->layout->render();
    }

}