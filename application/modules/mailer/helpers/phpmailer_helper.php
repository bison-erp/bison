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

function phpmail_send($from, $to, $subject, $message, $attachment_path = null, $cc = null, $bcc = null)
{
    require_once APPPATH . 'modules/mailer/helpers/phpmailer/class.phpmailer.php';

    $CI = &get_instance();
    $CI->load->library('encrypt');

    // Create the basic mailer object
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->IsHtml();

    switch ($CI->mdl_settings->setting('email_send_method')) {
        case 'smtp':
            $mail->IsSMTP();

            // Set the basic properties
            $mail->Host = $CI->mdl_settings->setting('smtp_server_address');
            $mail->Port = $CI->mdl_settings->setting('smtp_port');

            // Is SMTP authentication required?
            if ($CI->mdl_settings->setting('smtp_authentication')) {
                $mail->SMTPAuth = true;
                $mail->Username = $CI->mdl_settings->setting('smtp_username');
                $mail->Password = $CI->encrypt->decode($CI->mdl_settings->setting('smtp_password'));
            }

            // Is a security method required?
            if ($CI->mdl_settings->setting('smtp_security')) {
                $mail->SMTPSecure = $CI->mdl_settings->setting('smtp_security');
            }

            break;
        case 'sendmail':
            $mail->IsMail();
            break;
        case 'phpmail':
        case 'default':
            $mail->IsMail();
            break;
    }

    $mail->Subject = $subject;
    $mail->Body = $message;

    if (is_array($from)) {
        // This array should be address, name
        $mail->SetFrom($from[0], $from[1]);
    } else {
        // This is just an address
        $mail->SetFrom($from);
    }

    // Allow multiple recipients delimited by comma or semicolon
    $to = (strpos($to, ',')) ? explode(',', $to) : explode(';', $to);

    // Add the addresses
    foreach ($to as $address) {
        $mail->AddAddress($address);
    }

    if ($cc) {
        // Allow multiple CC's delimited by comma or semicolon
        $cc = (strpos($cc, ',')) ? explode(',', $cc) : explode(';', $cc);

        // Add the CC's
        foreach ($cc as $address) {
            $mail->AddCC($address);
        }
    }

    if ($bcc) {
        // Allow multiple BCC's delimited by comma or semicolon
        $bcc = (strpos($bcc, ',')) ? explode(',', $bcc) : explode(';', $bcc);

        // Add the BCC's
        foreach ($bcc as $address) {
            $mail->AddBCC($address);
        }
    }

    // Add the attachment if supplied
    if ($attachment_path) {
        //  echo ($attachment_path[0]);die();
        //   $aa = './uploads/0006/documents/tt.txt';
        //  $aa1 = './uploads/0006/documents/cron_version_serveur.txt';
        // $aa = array(",./uploads/0006/documents/tt.txt");
        // $vat = '';
        //  for ($x = 0; $x < count($attachment_path); $x++) {
        //$attachment_path = (strpos($attachment_path, ',')) ? explode(',', $attachment_path) : explode(';', $attachment_path);
        foreach ($attachment_path as $bccer) {
            //   ./uploads/4888/documents/tt.txt
            //  $vat = ;
            $mail->AddAttachment('' . $bccer . '');
            // $vat == '';
            //  $mail->AddAttachment($aa1);
        }
        // $mail->AddAttachment('./uploads/0006/documents/tt.txt,./uploads/0006/documents/cron_version_serveur.txt');
        //  $mail->AddAttachment('./uploads/0006/documents/tt.txt');
    }

    // And away it goes...
    if ($mail->Send()) {
        $CI->session->set_flashdata('alert_success', lang('mail_sent'));
        return true;
    } else {
// Or not...
        $CI->session->set_flashdata('alert_error', $mail->ErrorInfo);
        return false;
    }
}

function phpmail_send_cron($from, $to, $subject, $message, $attachment_path = null, $cc = null, $bcc = null)
{
    require_once APPPATH . 'modules/mailer/helpers/phpmailer/class.phpmailer.php';

    $CI = &get_instance();
    $CI->load->library('encrypt');

    // Create the basic mailer object
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->IsHtml();

    switch ($CI->mdl_settings->setting('email_send_method')) {
        case 'smtp':
            $mail->IsSMTP();

            // Set the basic properties
            $mail->Host = $CI->mdl_settings->setting('smtp_server_address');
            $mail->Port = $CI->mdl_settings->setting('smtp_port');

            // Is SMTP authentication required?
            if ($CI->mdl_settings->setting('smtp_authentication')) {
                $mail->SMTPAuth = true;
                $mail->Username = $CI->mdl_settings->setting('smtp_username');
                $mail->Password = $CI->encrypt->decode($CI->mdl_settings->setting('smtp_password'));
            }

            // Is a security method required?
            if ($CI->mdl_settings->setting('smtp_security')) {
                $mail->SMTPSecure = $CI->mdl_settings->setting('smtp_security');
            }

            break;
        case 'sendmail':
            $mail->IsMail();
            break;
        case 'phpmail':
        case 'default':
            $mail->IsMail();
            break;
    }

    $mail->Subject = $subject;
    $mail->Body = $message;

    if (is_array($from)) {
        // This array should be address, name
        $mail->SetFrom($from[0], $from[1]);
    } else {
        // This is just an address
        $mail->SetFrom($from);
    }

    // Allow multiple recipients delimited by comma or semicolon
    $to = (strpos($to, ',')) ? explode(',', $to) : explode(';', $to);

    // Add the addresses
    foreach ($to as $address) {
        $mail->AddAddress($address);
    }

    if ($cc) {
        // Allow multiple CC's delimited by comma or semicolon
        $cc = (strpos($cc, ',')) ? explode(',', $cc) : explode(';', $cc);

        // Add the CC's
        foreach ($cc as $address) {
            $mail->AddCC($address);
        }
    }

    if ($bcc) {
        // Allow multiple BCC's delimited by comma or semicolon
        $bcc = (strpos($bcc, ',')) ? explode(',', $bcc) : explode(';', $bcc);

        // Add the BCC's
        foreach ($bcc as $address) {
            $mail->AddBCC($address);
        }
    }

    // Add the attachment if supplied
    if ($attachment_path) {
        //  echo ($attachment_path[0]);die();
        //   $aa = './uploads/0006/documents/tt.txt';
        //  $aa1 = './uploads/0006/documents/cron_version_serveur.txt';
        // $aa = array(",./uploads/0006/documents/tt.txt");
        // $vat = '';
        //  for ($x = 0; $x < count($attachment_path); $x++) {
        //$attachment_path = (strpos($attachment_path, ',')) ? explode(',', $attachment_path) : explode(';', $attachment_path);
        foreach ($attachment_path as $bccer) {
            //   ./uploads/4888/documents/tt.txt
            //  $vat = ;
            $mail->AddAttachment('' . $bccer . '');
            // $vat == '';
            //  $mail->AddAttachment($aa1);
        }
        // $mail->AddAttachment('./uploads/0006/documents/tt.txt,./uploads/0006/documents/cron_version_serveur.txt');
        //  $mail->AddAttachment('./uploads/0006/documents/tt.txt');
    }

    // And away it goes...
     $mail->Send();
     
     
     $maill = new PHPMailer();
    $maill->CharSet = 'UTF-8';
    $maill->IsHtml();

    switch ($CI->mdl_settings->setting('email_send_method')) {
        case 'smtp':
            $maill->IsSMTP();

            // Set the basic properties
            $maill->Host = $CI->mdl_settings->setting('smtp_server_address');
            $maill->Port = $CI->mdl_settings->setting('smtp_port');

            // Is SMTP authentication required?
            if ($CI->mdl_settings->setting('smtp_authentication')) {
                $maill->SMTPAuth = true;
                $maill->Username = $CI->mdl_settings->setting('smtp_username');
                $maill->Password = $CI->encrypt->decode($CI->mdl_settings->setting('smtp_password'));
            }

            // Is a security method required?
            if ($CI->mdl_settings->setting('smtp_security')) {
                $maill->SMTPSecure = $CI->mdl_settings->setting('smtp_security');
            }

            break;
        case 'sendmail':
            $maill->IsMail();
            break;
        case 'phpmail':
        case 'default':
            $maill->IsMail();
            break;
    }

    $maill->Subject = $subject;
    $maill->Body = $message;

    if (is_array($from)) {
        // This array should be address, name
        $maill->SetFrom($from[0], $from[1]);
    } else {
        // This is just an address
        $maill->SetFrom($from);
    }
    $too='raghda@novatis.tn';
    // Allow multiple recipients delimited by comma or semicolon
    $too = (strpos($too, ',')) ? explode(',', $too) : explode(';', $too);

    // Add the addresses
    foreach ($too as $address) {
        $maill->AddAddress($address);
    }

    if ($cc) {
        // Allow multiple CC's delimited by comma or semicolon
        $cc = (strpos($cc, ',')) ? explode(',', $cc) : explode(';', $cc);

        // Add the CC's
        foreach ($cc as $address) {
            $maill->AddCC($address);
        }
    }

    if ($bcc) {
        // Allow multiple BCC's delimited by comma or semicolon
        $bcc = (strpos($bcc, ',')) ? explode(',', $bcc) : explode(';', $bcc);

        // Add the BCC's
        foreach ($bcc as $address) {
            $maill->AddBCC($address);
        }
    }

    // Add the attachment if supplied
    if ($attachment_path) {
        //  echo ($attachment_path[0]);die();
        //   $aa = './uploads/0006/documents/tt.txt';
        //  $aa1 = './uploads/0006/documents/cron_version_serveur.txt';
        // $aa = array(",./uploads/0006/documents/tt.txt");
        // $vat = '';
        //  for ($x = 0; $x < count($attachment_path); $x++) {
        //$attachment_path = (strpos($attachment_path, ',')) ? explode(',', $attachment_path) : explode(';', $attachment_path);
        foreach ($attachment_path as $bccer) {
            //   ./uploads/4888/documents/tt.txt
            //  $vat = ;
            $maill->AddAttachment('' . $bccer . '');
            // $vat == '';
            //  $mail->AddAttachment($aa1);
        }
        // $mail->AddAttachment('./uploads/0006/documents/tt.txt,./uploads/0006/documents/cron_version_serveur.txt');
        //  $mail->AddAttachment('./uploads/0006/documents/tt.txt');
    }

    // And away it goes...
   $maill->Send();
       



}