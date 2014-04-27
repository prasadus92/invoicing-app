<?php

if (isset($_GET['redirect'])) {
    include_once( 'core/class.ManageInvoice.php' );
    include_once( 'session.php' );
    $invoice_init = new ManageInvoice;

    $deleteInvoiceInfo = $invoice_init->listInvoice($logged_in_user, array('id' => base64_decode($_GET['redirect'])));
    if ($deleteInvoiceInfo !== 0) {
        $delete_invoice = $invoice_init->deleteInvoice(array('id' => base64_decode($_GET['redirect'])));
        if ($delete_invoice !== 0) {
            header("location: list_invoices.php?status=success");
        } else {
            header("location: list_invoices.php?status=error");
        }
    } else {
        header("location: list_invoices.php?status=error");
    }
}
?>