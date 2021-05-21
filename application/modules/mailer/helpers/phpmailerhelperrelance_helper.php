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

function phpmail_send($from, $to, $ip_settingsval, $subject, $message, $attachment_path = null, $cc = null, $bcc = null)
{
    require_once APPPATH . 'modules/mailer/helpers/phpmailer/class.phpmailer.php';
    $CI = &get_instance();
    $CI->load->library('encrypt');

    // Create the basic mailer object
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->IsHtml();

    switch ($ip_settingsval[42]->setting_value) {
        case 'smtp':
            $mail->IsSMTP();

            // Set the basic properties
            $mail->Host = $ip_settingsval[43]->setting_value;
            $mail->Port = $ip_settingsval[46]->setting_value;

            // Is SMTP authentication required?
            if ($ip_settingsval[44]->setting_value) {
                $mail->SMTPAuth = true;
                $mail->Username = $ip_settingsval[45]->setting_value;
                $mail->Password = $CI->encrypt->decode($ip_settingsval[58]->setting_value);
            }

            // Is a security method required?
            if ($ip_settingsval[47]->setting_value) {
                $mail->SMTPSecure = $ip_settingsval[47]->setting_value;
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

    /*   $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = '37.187.94.84'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'noreply@novatis.tn'; // SMTP username
    $mail->Password = 'iIpv4^2F7nWnubsv'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to
     */
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
        for ($x = 0; $x < count($attachment_path); $x++) {
            $mail->AddAttachment($attachment_path[$x]);
        }
    }
    if ($mail->Send()) {
        return true;
    } else {
        // Or not...
        $mail->ErrorInfo;
        return false;
    }
    // $mail->Send();

}