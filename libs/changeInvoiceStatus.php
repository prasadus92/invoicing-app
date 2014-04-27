<?php

if ($_POST) {
    include_once( '../core/class.ManageInvoice.php' );
    include_once( 'session.php' );
    $update_invoice_init = new ManageInvoice;
    $paid_amount = $_POST['paid_amount'];

    $get_invoice_total = $update_invoice_init->listInvoice($logged_in_user, array('id' => base64_decode($_POST['primary_id'])));

    foreach ($get_invoice_total as $it) {
        $amount_paid = $it['invoice_total'];
    }
    if ($_POST['new_status'] == 'Pending') {
        $amount_paid = '0';
    } else if ($_POST['new_status'] == 'Partially Paid') {
        $amount_paid = $paid_amount;
    }

    $param = array('invoice_status' => $_POST['new_status'], 'invoice_paid' => $amount_paid);

    $update_status = $update_invoice_init->updateInvoiceInfo($param, base64_decode($_POST['primary_id']));

    if ($update_status) {
        echo 'Changes have been made';
    } else {
        echo 'No changes have been made';
    }
}
?>