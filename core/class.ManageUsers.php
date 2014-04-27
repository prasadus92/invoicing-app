<?php

include_once( 'class.database.php' );

class ManageUsers {

    public $link;

    function __construct() {
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function loginUser($username, $password) {
        $query = $this->link->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
        return $query->rowCount();
    }

    function getUserInfo($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT * FROM users WHERE $key = '$value'");
            }
        } else {
            $query = $this->link->query("SELECT * FROM users");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function createUser($username, $email, $password, $default_currency, $default_currency_text, $default_currency_invoice, $default_currency_format, $user_role, $company_logo, $show_logo_invoice, $watermark_invoice, $watermark_image, $user_status, $access_token, $your_company_name, $company_street_address, $company_city, $company_state, $company_phone_no) {
        $query = $this->link->prepare("INSERT INTO users (username,email,password,default_currency,default_currency_text,default_currency_invoice,default_currency_format,user_role,company_logo,show_logo_invoice,watermark_invoice,watermark_image,user_status,access_token,your_company_name,company_street_address,company_city,company_state,company_phone_no)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
			");
        $values = array($username, $email, $password, $default_currency, $default_currency_text, $default_currency_invoice, $default_currency_format, $user_role, $company_logo, $show_logo_invoice, $watermark_invoice, $watermark_image, $user_status, $access_token, $your_company_name, $company_street_address, $company_city, $company_state, $company_phone_no);
        $query->execute($values);
        return $query->rowCount();
    }

    function updateUserInfo($param, $where) {
        foreach ($param as $key => $value) {
            $query = $this->link->query("UPDATE users SET $key = '$value' WHERE username = '$where'");
        }
        return $query->rowCount();
    }

    function deleteUser($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("DELETE FROM users WHERE $key = '$value'");
            }
        }
        return $query->rowCount();
    }

    function updateEmailSettings($param) {
        foreach ($param as $key => $value) {
            $query = $this->link->query("UPDATE email_settings SET $key = '$value'");
        }
        return $query->rowCount();
    }

    function getEmailSettings() {
        $query = $this->link->query("SELECT * FROM email_settings");
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function createEmailLogs($email_subject, $email_description, $invoice_refrence_id, $client_refrence_id, $send_on_email, $sent_from_email, $email_status, $email_sent_by, $email_sent_on_date, $cc_to_email, $original_pdf_link) {
        $query = $this->link->prepare("INSERT INTO invoice_emails (email_subject,email_description,invoice_refrence_id,client_refrence_id,send_on_email,sent_from_email,email_status,email_sent_by,email_sent_on_date,cc_to_email,original_pdf_link)
				VALUES (?,?,?,?,?,?,?,?,?,?,?)
				");
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


        $values = array($email_subject, $email_description, $invoice_refrence_id, $client_refrence_id, $send_on_email, $sent_from_email, $email_status, $email_sent_by, $email_sent_on_date, $cc_to_email, $original_pdf_link);
        $query->execute($values);
        return $this->link->lastInsertId();
    }

}

?>