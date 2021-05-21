<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * Tracking
 *
 * A free and open source web based invoicing system
 *
 * @package        Tracking
 * @author        Kovah (www.kovah.de)
 * @copyright    Copyright (c) 2012 - 2019 Tracking.com
 * @license        https://Tracking.com/license.txt
 * @link        https://Tracking.com
 *
 */

class Tracking extends CI_Controller
{

    public function __construct()
    {
        Parent::__construct();
        $this->load->model("mdl_tracking");
    }
    public function index()
    {
        // die('1');
        $this->load->view("settings/partial_tracking.php", array());
    }

    public function tracking()
    {
        //return var_dump('1');die();
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $track = $this->mdl_tracking->get_tracking();

        $data = array();

        foreach ($track->result() as $r) {

            $data[] = array(
                $r->date,
                $r->ip,
                //  $r->author,
                //  $r->rating . "/10 Stars",
                // $r->publisher,
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $track->num_rows(),
            "recordsFiltered" => $track->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function trackingajax()
    {
        $num = $this->input->post('num');
        $this->db->like('log_action', 'rappel_devis');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_logs.log_field1');
        $this->db->join('ip_quotes', 'ip_quotes.quote_id = ip_logs.log_field2');
        $this->db->join('ip_users', 'ip_clients.user_id = ip_users.user_id');
        $this->db->order_by('log_date', 'DESC'); //ip_tracking

        //$this->db->limit(($num * 10) + 1, 10);
        //echo $num;
        $traking1 = $this->db->get("ip_logs")->result();
        $traking = $this->db->get("ip_logs", 10, $num * 10)->result();
        //header('Content-Type: application/json');
        $res = "";
        foreach ($traking as $i) {
            /* $res .= "<td>" . $i->id_from . "</td>";
            $res .= "<td>" . $i->id_to . "</td>";
            $res .= "<td>" . $i->date . "</td>";
            $res .= "<td></td>";
            $res .= "<td>" . $i->vu . "</td>";*/
            $res .= "<tr>";
            $res .= "<td>" . $i->user_email . "</td>";
            $res .= "<td>" . $i->client_email . "</td>";
            $res .= "<td>" . $i->log_date . "</td>";
            $res .= "<td>" . $i->log_id . "</td>";
            $res .= "<td></td>";
            $res .= "</tr>";
        }
        /*  if (count($traking1 > $traking)) {

        }*/
        // echo json_encode($res);
        echo $res;
    }

}