<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * InvoicePlane
 *
 * A free and open source web based invoicing system
 *
 * @package        Mdl_Tracking
 * @author        Kovah (www.kovah.de)
 * @copyright    Copyright (c) 2012 - 2019 Mdl_Tracking.com
 * @license        https://Tracking.com/license.txt
 * @link        https://Tracking.com
 *
 */

class Mdl_Tracking extends CI_Model
{
    public function get_tracking()
    {
        return $this->db->get("ip_logs");
    }
}