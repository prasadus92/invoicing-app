<?php

include_once( 'class.database.php' );

class ManageEmails {

    public $link;

    function __construct() {
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
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