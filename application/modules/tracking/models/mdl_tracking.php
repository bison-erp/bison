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

class Mdl_Tracking extends Response_Model
{

    public $table = 'ip_tracking';
    public $primary_key = 'ip_tracking.log_id';

    public function getAlltrack()
    {
        $this->db->select('action,date,ip,id_from,id_to,number,id_action,vu');
        $this->db->from('ip_tracking');
        $query = $this->db->get();
        return $query->result();
    }

}