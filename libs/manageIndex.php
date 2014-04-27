<?php

include_once( 'core/class.ManageIndex.php' );
include_once( 'date.php' );
include_once( 'session.php' );

$index_init = new ManageIndex;
if (isset($_GET['start_range'])) {
    $start_range = $_GET['start_range'];
    $end_range = $_GET['end_range'];
} else {
    $end_range = $date;
    $oneWeekAgo = strtotime('-1 week', strtotime($date));
    $start_range = date('Y-m-d', $oneWeekAgo);
}
$all_invoice_total = $index_init->invoiceTotal($logged_in_user, $start_range, $end_range, array('invoice_total' => ''));

if ($all_invoice_total !== 0) {
    foreach ($all_invoice_total as $l) {
        $invoice_all_total = $l->INVOICE_TOTAL;
        if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
            $invoice_all_total_display = $refrence_currency . ' ' . $invoice_all_total;
        } else {
            $invoice_all_total_display = $invoice_all_total . ' ' . $refrence_currency;
        }
    }
}

$paid_invoice_total = $index_init->invoiceTotal($logged_in_user, $start_range, $end_range, array('invoice_paid' => ''));
if ($paid_invoice_total !== 0) {
    foreach ($paid_invoice_total as $p) {
        $invoice_paid_total = $p->INVOICE_TOTAL;
        if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
            $invoice_paid_total_display = $refrence_currency . ' ' . $invoice_paid_total;
        } else {
            $invoice_paid_total_display = $invoice_paid_total . ' ' . $refrence_currency;
        }
    }
}
$invoice_pending_total = $invoice_all_total - $invoice_paid_total;
if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
    $invoice_pending_total = $refrence_currency . ' ' . $invoice_pending_total;
} else {
    $invoice_pending_total = $invoice_pending_total . ' ' . $refrence_currency;
}


$selected_clients = $index_init->getSelectedClients($logged_in_user, $start_range, $end_range);
$selected_invoices = $index_init->getSelectedInvoices($logged_in_user, $start_range, $end_range);
?>