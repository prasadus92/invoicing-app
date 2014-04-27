<?php

ob_start();
include_once( '../core/class.ManageInvoice.php' );
include_once( 'currency.php' );
include_once( 'session.php' );
include_once( 'date.php' );

$invoice_init = new ManageInvoice;

$company_name = $_POST['company_name'];
$user_street = $_POST['user_street'];
$user_city = $_POST['user_city'];
$user_state = $_POST['user_state'];
$user_contact_num = $_POST['user_contact_num'];
$user_email = $_POST['user_email'];
$invoice_title = $_POST['invoice_title'];
$invoice_date = $_POST['invoice_date'];
$invoice_no = $_POST['invoice_no'];
$invoice_po = $_POST['invoice_po'];
$invoice_to = $_POST['invoice_to'];
$invoice_to_address = nl2br($_POST['invoice_to_address']);
$message = nl2br($_POST['message']);
$final_message = nl2br($_POST['final_message']);
$sales_tax_percen = $_POST['sales_tax_percen'];
$sno = $_POST['item_sno'];
$item_description = $_POST['item_description'];
$item_quantity = $_POST['item_quantity'];
$item_price = $_POST['item_price'];
$sub_total_text = $_POST['subtotal_text'];
$c_for_pdf = explode(' ', $_POST['refrence_currency_for_pdf']);
$pdf_currency = $c_for_pdf[0] . ' ' . $pdf_map[$c_for_pdf[0]];
$pdf_currency = str_replace('?', '', $pdf_currency);
$invoice_created_on_date = $date;

if (isset($_POST['refrence_logo'])) {
    $refrence_logo = '<img src="uploads/' . $_POST['refrence_logo'] . '" />';
} else {
    '';
}
$current_user = $_POST['generate_time_user'];
$recieved_default_currency_type = $_POST['connect_default_currency_type'];
$auto_suggest_client_id = $_POST['auto_suggest_client_id'];

if (isset($_POST['refrence_invoice']) && !empty($_POST['refrence_invoice'])) {
    $delete_invoice = $invoice_init->deleteInvoice(array('id' => base64_decode($_POST['refrence_invoice'])));
    $deleteInvoiceItems = $invoice_init->deleteInvoiceItems(array('invoice_refrence_id' => $_POST['refrence_invoice']));
}

if (!empty($sno)) {
    foreach ($sno as $key => $value) {
        if ($item_quantity[$key] != 0) {
            $items_total[] = $item_price[$key] * $item_quantity[$key];
        }
    }
    $sub_total = array_sum($items_total);
    $sales_tax_total = $sub_total * $sales_tax_percen / 100;
    $grand_total = $sub_total + $sales_tax_total;

    if (isset($_POST['refrence_invoice']) && !empty($_POST['refrence_invoice'])) {
        $create_invoice = $invoice_init->createInvoice($invoice_created_on_date, $company_name, $user_street, $user_city, $user_state, $user_contact_num, $user_email, $invoice_title, $invoice_date, $invoice_no, $invoice_po, $invoice_to, $invoice_to_address, $message, $final_message, $sub_total_text, $_POST['sales_tax_text'], $sales_tax_percen, $_POST['grand_total_text'], $grand_total, 0, 'Draft', $logged_in_user, $auto_suggest_client_id, base64_decode($_POST['refrence_invoice']));
        $success = 'Edited';
    } else {
        $create_invoice = $invoice_init->createInvoice($invoice_created_on_date, $company_name, $user_street, $user_city, $user_state, $user_contact_num, $user_email, $invoice_title, $invoice_date, $invoice_no, $invoice_po, $invoice_to, $invoice_to_address, $message, $final_message, $sub_total_text, $_POST['sales_tax_text'], $sales_tax_percen, $_POST['grand_total_text'], $grand_total, 0, 'Draft', $logged_in_user, $auto_suggest_client_id);
        $success = 'Created';
    }
    if ($create_invoice) {
        foreach ($sno as $key => $value) {
            if ($item_quantity[$key] != 0) {
                $insert_items = $invoice_init->insertItems($item_description[$key], $item_quantity[$key], $item_price[$key], $item_price[$key] * $item_quantity[$key], base64_encode($create_invoice));
            }
        }
        echo 'created';
        header("location: ../invoice.php?invoice_id=" . base64_encode($create_invoice) . "&&success=" . $success . "");
    } else {
        echo 'error';
    }
}
?>
