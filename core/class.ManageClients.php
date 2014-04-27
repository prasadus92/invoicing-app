<?php

include_once( 'class.database.php' );

class ManageClients {

    public $link;

    function __construct() {
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function listClients($login_username, $param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT * FROM clients WHERE $key = '$value' AND client_created_by = '$login_username' ORDER BY id DESC");
            }
        } else {
            $query = $this->link->query("SELECT * FROM clients WHERE client_created_by = '$login_username' ORDER BY id DESC");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function createClient($client_business_name, $client_tagline, $client_website, $about_client, $client_payment_date, $client_name, $client_email_address, $client_contact_no, $client_address, $client_created_by, $client_created_on_date, $id = null) {
        if (isset($id)) {

            $query = $this->link->prepare("INSERT INTO clients (client_business_name,client_tagline,client_website,about_client,client_payment_date,client_name,client_email_address,client_contact_no,client_address,client_created_by,client_created_on_date,id)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
				");
            $values = array($client_business_name, $client_tagline, $client_website, $about_client, $client_payment_date, $client_name, $client_email_address, $client_contact_no, $client_address, $client_created_by, $client_created_on_date, $id);
        } else {
            $query = $this->link->prepare("INSERT INTO clients (client_business_name,client_tagline,client_website,about_client,client_payment_date,client_name,client_email_address,client_contact_no,client_address,client_created_by,client_created_on_date)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)
				");
            $values = array($client_business_name, $client_tagline, $client_website, $about_client, $client_payment_date, $client_name, $client_email_address, $client_contact_no, $client_address, $client_created_by, $client_created_on_date);
        }
        $query->execute($values);
        return $this->link->lastInsertId();
    }

    function suggestClient($login_username, $param) {
        foreach ($param as $key => $value) {
            $query = $this->link->query("SELECT * FROM clients WHERE $key RLIKE '$value' AND client_created_by = '$login_username'");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function deleteClient($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("DELETE FROM clients WHERE $key = '$value'");
            }
            return $query->rowCount();
        }
    }

    function updateClientInfo($param, $where) {
        foreach ($param as $key => $value) {
            $query = $this->link->query("UPDATE clients SET $key = '$value' WHERE id = '$where'");
        }
        return $query->rowCount();
    }

}

?>