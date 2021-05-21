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

class Tracking extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_tracking');
    }
    public function index()
    {

        $this->layout->buffer('content', 'tracking/index');

        $this->layout->render();
        //    $this->load->view('tracking/index');
        //    $this->layout->render();
        /*  $sess_product_index = $this->session->userdata['product_index'];
    if ($sess_product_index == 1) {
    $this->mdl_families->paginate(site_url('families/index'), $page);
    $families = $this->mdl_families->result();

    $this->layout->set('families', $families);
    $this->layout->buffer('content', 'families/index');
    $this->layout->render();
    } else {
    redirect('sessions/login');
    }*/
    }

    public function getUser($id)
    {

        $this->db->select('user_name');
        $this->db->where('user_id =', $id);
        $user = $this->db->get('ip_users')->result();
        return ($user[0]->user_name);
    }
    public function extrack()
    {
        // $typelu = $this->input->post('typelu');
        $aa = $this->load->model("mdl_tracking");
        $data = array();
        foreach ($aa->getAlltrack() as $row) {
            $data[] = array(

                "from" => $this->getUser($row->id_from),
                "to" => $this->getclient($row->id_to),
                "date" => $row->date,
                "object" => $row->action == 'rappel_devis' ? 'Devis' . $row->number . ': ' . $this->getnature(0, $row->id_action) : 'Facture' . $row->number . ': ' . $this->getnature(1, $row->id_action),
                "etat" => $row->vu == '1' ? 'Lu' : 'Non lu',
            );
        }
        echo json_encode(
            array("data" => $data)
        );

    }
    public function getclient($id)
    {
        $this->db->select('client_name,client_prenom');
        $this->db->where('client_id =', $id);
        $client = $this->db->get('ip_clients')->result();
        return ($client[0]->client_name . " " . $client[0]->client_prenom);
    }

    public function getnature($type, $id)
    {
        $res = "";
        if ($type == 0) {
            $this->db->select('quote_nature');
            $this->db->where('quote_id =', $id);
            $res .= $this->db->get('ip_quotes')->result()[0]->quote_nature;
        } else {
            $this->db->select('nature');
            $this->db->where('invoice_id =', $id);
            $res .= $this->db->get('ip_invoices')->result()[0]->nature;
        }

        return ($res);
    }
/*
public function track()
{
// $typelu = $this->input->post('typelu');
$aa = $this->load->model("mdl_tracking");
$data = array();
foreach ($aa->getAlltrack() as $row) {
$data[] = array(

"from" => $this->getUser($row->id_from),
"to" => $this->getclient($row->id_to),
"date" => $row->date,
"object" => $row->action == 'rappel_devis' ? 'Devis' . $row->number . ': ' . $this->getnature(0, $row->id_action) : 'Facture' . $row->number . ': ' . $this->getnature(1, $row->id_action),
"etat" => $row->vu == '1' ? 'Lu' : 'Non lu',
);
}

$data = array(
"data" => $data,
);
$this->layout->load_view('tracking/track', $data);

}*/

}