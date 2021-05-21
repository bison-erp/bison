<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * A free and open source web based invoicing system
 *
 * @package        InvoicePlane
 * @author        oussema (www.kovah.de)
 * @copyright    Copyright (c) 2012 - 2019 InvoicePlane.com
 * @license        https://invoiceplane.com/license.txt
 * @link        https://invoiceplane.com
 *
 */

class Mdl_Rappel extends Response_Model
{

    public $table = 'ip_rappelmail';
    public $primary_key = 'ip_rappelmail.ip_rappelmail_id';

    //pour afficher les dates dans devis

    public function getRappel($id, $type)
    {
        $this->db->select("daterappel,idobject");
        if ($type == 0) {

            $this->db->where(array('idobject' => $id, 'type' => "quote"));
        } else {
            $this->db->where(array('idobject' => $id, 'type' => "invoice"));
        }
        $this->db->from('ip_rappelmail');

        return $this->db->get()->result();
    }

    // pour modifier le date relance
    public function updateDateRelance($id, $resdate, $type)
    {
        // $array = array('idobject' => $id, 'type' => 'quote', 'daterappel' => $date);
        if ($type == 0) {
            $array1 = array('idobject' => $id, 'type' => 'quote');
            $this->db->delete('ip_rappelmail', $array1);

            $resdatecount = explode(',', $resdate);
            //   return var_dump($resdatecount);
            if (strlen($resdate) > 0) {
                for ($i = 0; $i < count($resdatecount); $i++) {

                    $data = array('idobject' => $id, 'type' => 'quote', 'daterappel' => $resdatecount[$i]);
                    //    echo $resdatecount[8] . 'hh';
                    $this->db->insert('ip_rappelmail', $data);
                }

            }

        } else {

            $array1 = array('idobject' => $id, 'type' => 'invoice');
            $this->db->delete('ip_rappelmail', $array1);

            $resdatecount = explode(',', $resdate);

            if (strlen($resdate) > 0) {
                for ($i = 0; $i < count($resdatecount); $i++) {

                    $data = array('idobject' => $id, 'type' => 'invoice', 'daterappel' => $resdatecount[$i]);
                    $this->db->insert('ip_rappelmail', $data);
                }
            }
        }
    }
}