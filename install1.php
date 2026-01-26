<?php

include_once 'config.php';
$db_name = DB_NAME;
$db_user = DB_USER;
$db_pass = DB_PASSWORD;
$db_host = DB_HOST;

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';

$ip_address = $_SERVER['REMOTE_ADDR'];

$pass2 = password_hash($pass1, PASSWORD_DEFAULT);

if (empty($email) || empty($pass1) || empty($username)) {
    echo 'All fields Required';
} else {
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $fetch_rows = $stmt->rowCount();

    if ($fetch_rows >= 1) {
        echo 'Email already Exists';
    } else {
        $default_currency = 'USD';
        $default_currency_text = 'U.S. Dollars ($)';
        $default_currency_invoice = 'USD $';
        $md_username = md5($username);

        $stmt2 = $conn->prepare("INSERT INTO users (username, email, password, default_currency, default_currency_text, default_currency_invoice, company_logo, default_currency_format, show_logo_invoice, watermark_invoice, watermark_image, user_status, access_token, your_company_name, company_street_address, company_city, company_state, company_phone_no, user_role)
            VALUES (:username, :email, :password, :default_currency, :default_currency_text, :default_currency_invoice, 'default.png', 'Fappend', 'Yes', 'No', 'default_watermark.png', 'Active', :access_token, 'Your Company Name', 'Company Address', 'Company City', 'Company State', 'Company Phone No', 'Admin')");

        $result = $stmt2->execute([
            'username' => $username,
            'email' => $email,
            'password' => $pass2,
            'default_currency' => $default_currency,
            'default_currency_text' => $default_currency_text,
            'default_currency_invoice' => $default_currency_invoice,
            'access_token' => $md_username
        ]);

        if ($result) {
            $new_id = $conn->lastInsertId();
            $stmt3 = $conn->prepare("INSERT INTO email_settings (invoice_emails_from_toggle, config_company_emails_from, invoice_email_from)
                    VALUES ('User Registered Email', '', :email)");
            $stmt3->execute(['email' => $email]);
            echo 'Everything went right, Delete the files used for installation (recommended) <a href="install.php?alldelete=alldelete" id="created">Delete</a>';
        }
    }
}
?>
