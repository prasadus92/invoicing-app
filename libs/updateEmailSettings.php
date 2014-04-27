<?php

if ($_POST) {
    include_once( '../core/class.ManageUsers.php' );
    $email_settings_init = new ManageUsers;

    $invoice_emails_from_toggle = $_POST['invoice_emails_from_toggle'];
    $config_company_emails_from = $_POST['config_company_emails_from'];
    $invoice_email_from = $_POST['invoice_email_from'];

    $email_param = array('invoice_emails_from_toggle' => $invoice_emails_from_toggle, 'config_company_emails_from' => $config_company_emails_from, 'invoice_email_from' => $invoice_email_from);
    $update_user_info = $email_settings_init->updateEmailSettings($email_param);

    if ($update_user_info) {
        echo 'true';
    } else {
        echo 'Nothing have been upated';
    }
}
?>