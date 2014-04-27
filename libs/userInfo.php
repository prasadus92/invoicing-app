<?php

include_once( 'core/class.ManageUsers.php' );
$users_init = new ManageUsers;
$userInfo = $users_init->getUserInfo(array('username' => $logged_in_user));
$show_logo_array = array('Yes', 'No');
$watermark_options_array = array('No', 'Text Watermark', 'Image Watermark');
$default_currency_format_array = array(
    'AMT USD (&#36;)' => 'Fappend',
    '&#36; AMT' => 'Hprepend',
    'AMT &#36;' => 'Happend',
    'USD (&#36;) AMT' => 'Fprepend',
);

$default_pdf_footer_options = array('Yes', 'No');

$user_email_settings = $users_init->getEmailSettings();

$email_settings_invoice_options = array('User Registered Email', 'Custom Email');
?>