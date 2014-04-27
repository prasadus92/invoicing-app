<?php

include_once( 'core/class.ManageClients.php' );
include_once( 'core/class.ManageInvoice.php' );
include_once( 'core/class.ManageUsers.php' );

include_once( 'session.php' );
require_once('PHPMailer_5.2.1/class.phpmailer.php');
include_once( 'date.php' );

$client_init = new ManageClients;
$invoice_init = new ManageInvoice;
//	$email_settings_init = new ManageUsers;

$get_user_email_settings = $users_init->getEmailSettings();

if (isset($_GET['invoice_id'])) {
    $listInvoice = $invoice_init->listInvoice($logged_in_user, array('id' => base64_decode($_GET['invoice_id'])));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($listInvoice as $invoiceInfo) {
        $client_refrence_id = $invoiceInfo['invoice_to_company_id'];
        $email_client_info = $client_init->listClients($logged_in_user, array('id' => base64_decode($invoiceInfo['invoice_to_company_id'])));

        foreach ($email_client_info as $value) {
            $to_email = $value['client_email_address'];
            $to_name = $value['client_name'];
        }

        $from_name = $invoiceInfo['your_company_name'];
        if ($get_user_email_settings !== 0) {
            foreach ($get_user_email_settings as $emailSendingSettings) {
                if ($emailSendingSettings['invoice_emails_from_toggle'] == 'Custom Email') {
                    $reply_to = $emailSendingSettings['config_company_emails_from'];
                    $from_email = $emailSendingSettings['config_company_emails_from'];
                } else {
                    $reply_to = $company_email_address;
                    $from_email = $company_email_address;
                }
            }
        } else {
            $reply_to = $company_email_address;
            $from_email = $company_email_address;
        }
    }
    $subject = $_POST['email_subject'];
    $description = $_POST['email_content'];

    $body = '<!DOCTYPE html>
					<html lang="en">
					<head>
						<meta charset="utf-8">
					</head>
					<body>
						' . $description . '
					</body>
					</html>';

    $invoice_id = $_GET['invoice_id'];
    include_once( 'create_pdf.php');
    $file_path = $invoice_id . '_invoice.pdf';

    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->AddReplyTo($reply_to, $from_name);
    $mail->SetFrom($from_email, $from_name);
    $mail->AddAddress($to_email, $to_name);
    $mail->Subject = $subject;
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    $mail->AddAttachment($file_path);
    if (!$mail->Send()) {
        $error = "Email not configured, please contact administrator";
    } else {
        $insert_logs = $users_init->createEmailLogs($subject, $description, $invoice_id, $client_refrence_id, $to_email, $from_email, 'Sent', $logged_in_user, $date, '', '');
        $change_status_param = array('invoice_status' => 'Pending');
        $invoice_init->updateInvoiceInfo($change_status_param, base64_decode($invoice_id));
        $success = "Email Sent";
        unlink($invoice_id . '_invoice.pdf');
    }
}
?>