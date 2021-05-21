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

class Mdl_Documentrappel extends Response_Model
{

    public $table = 'ip_document_rappel';
    public $primary_key = 'ip_document_rappel.document_rappel_id';

}