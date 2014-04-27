<?php

include_once( 'class.database.php' );

class ManageIndex {

    public $link;

    function __construct() {
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function invoiceTotal($login_username, $start_range, $end_range, $param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT sum($key) AS INVOICE_TOTAL FROM invoices WHERE invoice_created_by = '$login_username' AND invoice_created_on BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
            }
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $query->setFetchMode(PDO::FETCH_OBJ);
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function getSelectedClients($login_username, $start_range, $end_range, $param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT * FROM clients WHERE $key = '$value' AND client_created_by = '$login_username' AND client_created_on_date BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
            }
        } else {
            $query = $this->link->query("SELECT * FROM clients WHERE client_created_by = '$login_username' AND client_created_on_date BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function getSelectedInvoices($login_username, $start_range, $end_range, $param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT * FROM invoices WHERE $key = '$value' AND invoice_created_by = '$login_username' AND invoice_created_on BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
            }
        } else {
            $query = $this->link->query("SELECT * FROM invoices WHERE invoice_created_by = '$login_username' AND invoice_created_on BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

}

?>