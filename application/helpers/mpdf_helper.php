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

function pdf_create($type, $html, $filename, $stream = true, $password = null)
{
    $CI = &get_instance();
    $folder_app = strtolower($CI->session->userdata['licence']);

    require_once APPPATH . 'helpers/mpdf/mpdf.php';
    $CI->load->model('societes/mdl_societes');
  //  $CI->load->model('bl/mdl_bl');
    $mpdf = new mPDF();
    $mpdf = new mPDF('', // mode - default ''
        '', // format - A4, for example, default ''
        0, // font size - default 0
        'Verdana, sans-serif', // default font family
        11, // margin_left
        15, // margin right
        10, // margin top
        30, // margin bottom
        5, // margin header
        10, // margin footer
        'L');
    $mpdf->SetAutoFont();
    $societe = $CI->mdl_societes->get_by_id(1);
    $mpdf->showImageErrors = true;
    $mpdf->pagenumPrefix = 'Page ';
    $mpdf->pagenumSuffix = ' / ';
    $foot = $CI->mdl_settings->setting('pdf_invoice_footer');
    $respdf = "";
    //1 invoice,0 quote
    $defaultbison = "";
    $sign = signature();
    if ($type == 1) {
        $respdf = $CI->mdl_invoices->getTypepdf();
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'Facture générée par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';
        }
    } elseif ($type == 2) {
        $respdf = 0;
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'Devis généré par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';

        }
    } elseif ($type == 3) {
        $respdf = $CI->mdl_bl->getTypepdf();
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'BL généré par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';

        }
    }elseif ($type == 4) {
        $respdf = $CI->mdl_commande->getTypepdf();
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'Commande généré par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';

        }
    }elseif ($type == 5) {
        $respdf = $CI->mdl_fabrication->getTypepdf();
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'fabrication généré par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';

        }
    } else {
        $respdf = $CI->mdl_quotes->getTypepdf();
        if ($sign == 1) {
            $defaultbison = $defaultbison . 'Devis généré par le logiciel <a href="https://www.bison.tn/" target="_blank">BISON</a>';

        }
    }
    //return die('hh' . $defaultbison);
    if ($respdf == 0) {
        $mpdf->SetHTMLFooter('<div style="margin-top:20px; border-top: 1px solid #000">
        <div style="margin-top: 5px;"><table  cellspacing="10" width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; border-spacing: 15px;"><tr>
        <td  width="70">' . $defaultbison . '</td>
        <td width="110" VALIGN="MIDDLE" align="left"><span>' . $foot . '</span></td>
        <td width="50" VALIGN="MIDDLE" align="right" >{PAGENO}{nbpg}</td>
        </tr></table></div></div>
        ');
    } else {
        $mpdf->SetHTMLFooter('<div style="margin-top:20px; border-top: 1px solid #000">
        <div style="margin-top: 5px;"><table  cellspacing="10" width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; border-spacing: 15px;"><tr>
        <td  width="70">' . $defaultbison . '</td>
        <td width="110" VALIGN="MIDDLE" align="left"><span></span></td>
        <td width="50" VALIGN="MIDDLE" align="right" >{PAGENO}{nbpg}</td>
        </tr></table></div></div>
        ');
    }
    $mpdf->SetProtection(array('copy', 'print'), $password, $password);
    $mpdf->WriteHTML($html);
    if ($stream) {
        return $mpdf->Output($filename . '.pdf', 'I');
    } else {
        $mpdf->Output('./uploads/' . $folder_app . '/temp/' . $filename . '.pdf', 'F');
        return './uploads/' . $folder_app . '/temp/' . $filename . '.pdf';
    }
}
function pdf_createrelance($type, $html, $filename, $stream = true, $password = null)
{
    $CI = &get_instance();
    $folder_app = strtolower($CI->session->userdata['licence']);

    require_once APPPATH . 'helpers/mpdf/mpdf.php';
    $CI->load->model('societes/mdl_societes');
    $mpdf = new mPDF();
    $mpdf = new mPDF('', // mode - default ''
        '', // format - A4, for example, default ''
        0, // font size - default 0
        'Verdana, sans-serif', // default font family
        11, // margin_left
        15, // margin right
        10, // margin top
        30, // margin bottom
        5, // margin header
        10, // margin footer
        'L');
    $mpdf->SetAutoFont();
    $societe = $CI->mdl_societes->get_by_id(1);

    $mpdf->pagenumPrefix = 'Page ';
    $mpdf->pagenumSuffix = ' / ';
    $foot = $CI->mdl_settings->setting('pdf_invoice_footer');
    $respdf = "";
    //1 invoice,0 quote
    if ($type == 1) {
        $respdf = $CI->mdl_invoices->getTypepdf();
    } else {
        $respdf = $CI->mdl_quotes->getTypepdf();
    }
    if ($respdf == 0) {
        $mpdf->SetHTMLFooter('<div style="margin-top:20px; border-top: 1px solid #000">
        <div style="margin-top: 5px;"><table  cellspacing="10" width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; border-spacing: 15px;"><tr>
        <td VALIGN="MIDDLE" align="left"><span>' . $foot . '</span></td>
        <td width="50" VALIGN="MIDDLE" align="right" >{PAGENO}{nbpg}</td>
        </tr></table></div></div>
        ');
    } else {
        $mpdf->SetHTMLFooter('<div></div>');
    }
    $mpdf->SetProtection(array('copy', 'print'), $password, $password);
    $mpdf->WriteHTML($html);

    if ($stream) {
        return $mpdf->Output($filename . '.pdf', 'I');
    } else {
        $mpdf->Output('./uploads/' . $folder_app . '/temprelance/' . $filename . '.pdf', 'F');
        return './uploads/' . $folder_app . '/temprelance/' . $filename . '.pdf';
    }
}

function pdf_create_invoice($html, $filename, $stream = true, $password = null)
{
    $CI = &get_instance();

    require_once APPPATH . 'helpers/mpdf/mpdf.php';
    $CI->load->model('societes/mdl_societes');
    $CI->load->model('settings/mdl_settings');
    $mpdf = new mPDF();
    $mpdf = new mPDF('', // mode - default ''
        '', // format - A4, for example, default ''
        0, // font size - default 0
        'Verdana, sans-serif', // default font family
        11, // margin_left
        15, // margin right
        10, // margin top
        45, // margin bottom
        5, // margin header
        10, // margin footer
        'L');
    $mpdf->SetAutoFont();
    $societe = $CI->mdl_societes->get_by_id(1);

    $mpdf->pagenumPrefix = 'Page ';
    $mpdf->pagenumSuffix = ' / ';

    $foot = $CI->mdl_settings->setting('pdf_invoice_footer');

    $mpdf->SetProtection(array('copy', 'print'), $password, $password);

    $mpdf->WriteHTML($html);

    if ($stream) {
        return $mpdf->Output($filename . '.pdf', 'I');
    } else {
        $mpdf->Output('./uploads/temp/' . $filename . '.pdf', 'F');
        return './uploads/temp/' . $filename . '.pdf';
    }
}

function pdf_create_in_folder($html, $folder_name, $filename)
{
    $CI = &get_instance();
    $folder_app = strtolower($CI->session->userdata['licence']);

    require_once APPPATH . 'helpers/mpdf/mpdf.php';
    $CI->load->model('societes/mdl_societes');
    $mpdf = new mPDF();
    $mpdf = new mPDF('', // mode - default ''
        '', // format - A4, for example, default ''
        0, // font size - default 0
        'Verdana, sans-serif', // default font family
        11, // margin_left
        15, // margin right
        10, // margin top
        30, // margin bottom
        5, // margin header
        10, // margin footer
        'L');
    $mpdf->SetAutoFont();
    $societe = $CI->mdl_societes->get_by_id(1);

    $mpdf->pagenumPrefix = 'Page ';
    $mpdf->pagenumSuffix = ' / ';

    $foot = $CI->mdl_settings->setting('pdf_invoice_footer');

    $mpdf->SetHTMLFooter('<div style="margin-top:20px; border-top: 1px solid #000">
<div style="margin-top: 5px;"><table  cellspacing="10" width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; border-spacing: 15px;"><tr>
<td VALIGN="MIDDLE" align="left"><span>' . $foot . '</span></td>
<td width="50" VALIGN="MIDDLE" align="right" >{PAGENO}{nbpg}</td>
</tr></table></div></div>
');

//    $mpdf->SetProtection(array('copy', 'print'), $password, $password);
    $mpdf->WriteHTML($html);
    $dir_path = './uploads/' . $folder_app . '/temp/' . $folder_name;
    if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
    }

    $mpdf->Output($dir_path . '/' . $filename . '.pdf', 'F');
    return $dir_path . '/' . $filename . '.pdf';
}
