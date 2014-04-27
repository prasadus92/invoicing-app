<?php

include_once 'config.php';
$db_name = DB_NAME;
$db_user = DB_USER;
$db_pass = DB_PASSWORD;
$db_host = DB_HOST;

$conn = mysql_connect($db_host, $db_user, $db_pass);
$db = mysql_select_db($db_name, $conn);


$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$username = $_POST['username'];

$ip_address = $_SERVER['REMOTE_ADDR'];

$pass2 = md5($pass1);

if (empty($email) || empty($pass1) || empty($username)) {
    echo 'All fields Required';
} else {

    $fetch = mysql_query("SELECT email FROM users WHERE email = '$email'");
    $fetch_rows = mysql_num_rows($fetch);

    if ($fetch_rows >= 1) {
        echo 'Email already Exists';
    } else {
        $default_currency = 'USD';
        $default_currency_text = 'U.S. Dollars ($)';
        $default_currency_invoice = 'USD $';
        $md_username = md5($username);

        $sql2 = mysql_query("INSERT INTO users (username,email,password,default_currency,default_currency_text,default_currency_invoice,company_logo,default_currency_format,show_logo_invoice,watermark_invoice,watermark_image,user_status,access_token,your_company_name,company_street_address,company_city,company_state,company_phone_no,user_role)
			VALUES ('$username','$email','$pass2','$default_currency','$default_currency_text','$default_currency_invoice','default.png','Fappend','Yes','No','default_watermark.png','Active','$md_username)','Your Company Name','Company Address','Company City','Company State','Company Phone No','Admin')") or die(mysql_error());

        if ($sql2) {
            $new_id = mysql_insert_id();
            $sql3 = mysql_query("INSERT INTO email_settings (invoice_emails_from_toggle,config_company_emails_from,invoice_email_from) 
					VALUES ('User Registered Email','','$email')");
            echo 'Everything went right, Delete the files used for installation (recommended) <a href="install.php?alldelete=alldelete" id="created">Delete</a>';
        }
    }
}
?>