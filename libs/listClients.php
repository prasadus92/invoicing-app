<?php

include_once( 'core/class.ManageClients.php' );
include_once( 'core/class.ManageInvoice.php' );
include_once( 'session.php' );
$client_init = new ManageClients;
$client_invoice_init = new ManageInvoice;

if (isset($_GET['client_id'])) {
    $listClients = $client_init->listClients($logged_in_user, array('id' => base64_decode($_GET['client_id'])));
} elseif (isset($_GET['sort'])) {
    $get_invoices_first = $client_invoice_init->listInvoice($logged_in_user, array('invoice_status' => 'Pending'));
    $clients_under = 'Payment Due';
    if ($get_invoices_first !== 0) {
        foreach ($get_invoices_first as $clientInfos) {
            $client_ids[] = $clientInfos['invoice_to_company_id'];
        }
    } else {
        $client_ids = 0;
    }

    if ($client_ids !== 0) {
        $client_ids = array_unique($client_ids);
        foreach ($client_ids as $search_for_client) {
            $get_pending_p_clients = $client_init->listClients($logged_in_user, array('id' => base64_decode($search_for_client)));
            if ($get_pending_p_clients !== 0) {
                $listClients[] = $get_pending_p_clients;
            }
        }
    }
} elseif (isset($_GET['user'])) {
    $listClients = $client_init->listClients(base64_decode($_GET['user']));
    $clients_under = 'Your Selected User';
} else {
    $listClients = $client_init->listClients($logged_in_user);
    $clients_under = 'All';
}
?>