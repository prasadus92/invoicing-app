<?php

if ($_POST) {
    include_once( 'session.php' );
    include_once( '../core/class.ManageUsers.php' );

    /* MANAGE CURRENCY */

    $map = array(
        'USD' => '&#36;',
        'CAD' => '&#36;',
        'GBP' => '&#163;',
        'EUR' => '&#8364;',
        'AUD' => '&#36;',
        'ARS' => '&#36;',
        'BRL' => 'R&#36;',
        'CNY' => '&#165;',
        'COP' => '&#36;',
        'HRK' => 'kn',
        'CZK' => 'Kc',
        'DKK' => 'kr',
        'HKD' => '&#36;',
        'INR' => 'Rs',
        'IDR' => 'Rp',
        'JPY' => '&#165;',
        'LTL' => 'Lt',
        'MYR' => 'RM',
        'MUR' => 'Rs',
        'MXN' => '&#36;',
        'NZD' => '&#36;',
        'NOK' => 'kr',
        'PKR' => 'Rs',
        'PLN' => 'zl',
        'SAR' => 'SR',
        'SGD' => '&#36;',
        'ZAR' => 'R',
        'SEK' => 'kr',
        'CHF' => 'SFr',
        'TRY' => 'TL'
    );

    $update_init = new ManageUsers;
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $new_password_repeat = $_POST['new_password_repeat'];
    $selected_currency = $_POST['selected_currency'];
    $currency = rtrim($_POST['currency']);
    $currency_text = explode('(', $_POST['currency_text']);
    $currency_format = $_POST['currency_format'];
    $default_currency_text = $currency_text[0] . ' (' . $map[$currency] . ')';
    $show_logo = $_POST['show_logo'];
    $add_watermark = $_POST['add_watermark'];
    $watermark_text_input = $_POST['watermark_text_input'];

    $your_company_name_settings = $_POST['your_company_name_settings'];
    $street_address_settings = $_POST['street_address_settings'];
    $city_settings = $_POST['city_settings'];
    $state_settings = $_POST['state_settings'];
    $phone_no = $_POST['phone_no'];
    $pdf_footer_text = $_POST['pdf_footer_text'];
    $pdf_footer_add = $_POST['pdf_footer_add'];

    if ($currency_format == 'Fappend' || $currency_format == 'Fprepend') {
        $default_currency_invoice = $currency . ' ' . $map[$currency];
    } elseif ($currency_format == 'Hprepend' || $currency_format == 'Happend') {
        $default_currency_invoice = $map[$currency];
    } else {
        $default_currency_invoice = $currency . ' ' . $map[$currency];
    }

    if (!empty($new_password)) {
        $update_param = array('email' => $email, 'default_currency_invoice' => $default_currency_invoice, 'default_currency' => $currency, 'default_currency_text' => $default_currency_text, 'show_logo_invoice' => $show_logo, 'watermark_invoice' => $add_watermark, 'watermark_text' => $watermark_text_input, 'default_currency_format' => $currency_format, 'your_company_name' => $your_company_name_settings, 'company_street_address' => $street_address_settings, 'company_city' => $city_settings, 'company_state' => $state_settings, 'company_phone_no' => $phone_no, show_pdf_footer => $pdf_footer_add, 'pdf_footer_text' => $pdf_footer_text, 'password' => md5($new_password));
    } else {
        $update_param = array('email' => $email, 'default_currency_invoice' => $default_currency_invoice, 'default_currency' => $currency, 'default_currency_text' => $default_currency_text, 'show_logo_invoice' => $show_logo, 'watermark_invoice' => $add_watermark, 'watermark_text' => $watermark_text_input, 'default_currency_format' => $currency_format, 'your_company_name' => $your_company_name_settings, 'company_street_address' => $street_address_settings, 'company_city' => $city_settings, 'company_state' => $state_settings, 'company_phone_no' => $phone_no, show_pdf_footer => $pdf_footer_add, 'pdf_footer_text' => $pdf_footer_text);
    }
    $update_info = $update_init->updateUserInfo($update_param, $logged_in_user);
    if (isset($update_info)) {
        echo 'true';
    }
}
?>