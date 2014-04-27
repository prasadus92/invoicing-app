<?php

if (isset($_GET['redirect'])) {
    include_once( 'session.php' );

    $deleteInvoiceInfo = $client_init->listClients($logged_in_user, array('id' => base64_decode($_GET['redirect'])));
    if ($deleteInvoiceInfo !== 0) {
        $delete_invoice = $client_init->deleteClient(array('id' => base64_decode($_GET['redirect'])));
        if ($delete_invoice !== 0) {
            header("location: list_clients.php?status=success");
        } else {
            header("location: list_clients.php?status=error");
        }
    } else {
        header("location: list_clients.php?status=error");
    }
}
?>