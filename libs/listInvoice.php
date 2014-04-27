<?php

include_once( 'core/class.ManageInvoice.php' );
include_once( 'session.php' );
include_once( 'date.php' );
$invoice_init = new ManageInvoice;

if (isset($_GET['start_range'])) {
    $start_range = $_GET['start_range'];
    $end_range = $_GET['end_range'];
} else {
    $end_range = $date;
    $oneWeekAgo = strtotime('-1 week', strtotime($date));
    $start_range = date('Y-m-d', $oneWeekAgo);
}

if (isset($_GET['invoice_id'])) {
    $listInvoice = $invoice_init->listInvoice($logged_in_user, array('id' => base64_decode($_GET['invoice_id'])));
    $invoice_items = $invoice_init->listInvoiceItems(array('invoice_refrence_id' => $_GET['invoice_id']));
} else {
    if (isset($_GET['sort'])) {
        $for_status = str_replace('-', ' ', $_GET['sort']);
        $listInvoice = $invoice_init->listInvoice($logged_in_user, array('invoice_status' => $for_status), $start_range, $end_range);
        $status_to_display = $for_status;
    } elseif (isset($_GET['client'])) {
        $listInvoice = $invoice_init->listInvoice($logged_in_user, array('invoice_to_company_id' => $_GET['client']), $start_range, $end_range);
        $status_to_display = 'Your Selected Client';
    } elseif (isset($_GET['user'])) {
        $listInvoice = $invoice_init->listInvoice(base64_decode($_GET['user']), $param = null, $start_range, $end_range);
        $status_to_display = 'Your Selected User';
    } else {
        $listInvoice = $invoice_init->listInvoice($logged_in_user, $param = null, $start_range, $end_range);
        $status_to_display = 'All';
    }
}

$invoice_status_array = array('Pending' => 'secondary', 'Paid' => 'success', 'Draft' => 'draft');
$invoice_tool_options_array = array('Move To Pending' => 'Pending', 'Partially Paid' => 'Partially Paid', 'Mark As Paid' => 'Paid');
?>