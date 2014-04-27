<?php

ob_start();
if (isset($_POST)) {
    include_once( '../core/class.ManageClients.php' );
    include_once( 'session.php' );
    include_once( 'date.php' );
    $client_init = new ManageClients;

    $client_business_name = $_POST['client_business_name'];
    $client_tagline = $_POST['client_tagline'];
    $about_client = $_POST['about_client'];
    $client_payment_date = $_POST['client_payment_date'];
    $client_name = $_POST['client_name'];
    $client_email_address = $_POST['client_email_address'];
    $client_contact_no = $_POST['client_contact_no'];
    $client_address = nl2br($_POST['client_address']);
    $client_website = $_POST['client_website'];

    if (isset($_POST['refrence_client_id'])) {
        $delete_client = $client_init->deleteClient(array('id' => base64_decode($_POST['refrence_client_id'])));
    }

    if (isset($_POST['refrence_client_id'])) {
        $insert_client = $client_init->createClient($client_business_name, $client_tagline, $client_website, $about_client, $client_payment_date, $client_name, $client_email_address, $client_contact_no, $client_address, $logged_in_user, $date, base64_decode($_POST['refrence_client_id']));
    } else {
        $insert_client = $client_init->createClient($client_business_name, $client_tagline, $client_website, $about_client, $client_payment_date, $client_name, $client_email_address, $client_contact_no, $client_address, $logged_in_user, $date);
    }

    if ($insert_client) {
        header("location: ../client.php?client_id=" . base64_encode($insert_client) . "&&success=Created");
    }
}
?>