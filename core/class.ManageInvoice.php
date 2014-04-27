<?php

include_once( 'class.database.php' );

class ManageInvoice {

    public $link;

    function __construct() {
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function createInvoice($invoice_created_on_date, $your_company_name, $your_street, $your_city_name, $your_state_name, $your_contact_no, $your_email, $invoice_title, $invoice_date, $invoice_no, $invoice_po, $invoice_to_company, $invoice_to_company_address, $invoice_message_top, $invoice_message_bottom, $sub_total_text, $sales_tax_text, $sales_tax, $g_total_text, $invoice_total, $invoice_paid, $invoice_status, $invoice_created_by, $invoice_to_company_id, $update_id = null) {
        if (isset($update_id)) {
            $query = $this->link->prepare("INSERT INTO invoices
				(invoice_created_on,id,your_company_name,your_street,your_city_name,your_state_name,your_contact_no,your_email,
				invoice_title,invoice_date,invoice_no,invoice_po,invoice_to_company,invoice_to_company_address,
				invoice_message_top,invoice_message_bottom,sub_total_text,sales_tax_text,sales_tax,g_total_text,invoice_total,invoice_paid,invoice_status,invoice_created_by,invoice_to_company_id)
				VALUES
				(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $values = array($invoice_created_on_date, $update_id, $your_company_name, $your_street, $your_city_name, $your_state_name, $your_contact_no, $your_email, $invoice_title, $invoice_date, $invoice_no, $invoice_po, $invoice_to_company, $invoice_to_company_address, $invoice_message_top, $invoice_message_bottom, $sub_total_text, $sales_tax_text, $sales_tax, $g_total_text, $invoice_total, $invoice_paid, $invoice_status, $invoice_created_by, $invoice_to_company_id);
            $query->execute($values);
        } else {
            $query = $this->link->prepare("INSERT INTO invoices 
				(invoice_created_on,your_company_name,your_street,your_city_name,your_state_name,your_contact_no,your_email,
				invoice_title,invoice_date,invoice_no,invoice_po,invoice_to_company,invoice_to_company_address,
				invoice_message_top,invoice_message_bottom,sub_total_text,sales_tax_text,sales_tax,g_total_text,invoice_total,invoice_paid,invoice_status,invoice_created_by,invoice_to_company_id)
				VALUES
				(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $values = array($invoice_created_on_date, $your_company_name, $your_street, $your_city_name, $your_state_name, $your_contact_no, $your_email, $invoice_title, $invoice_date, $invoice_no, $invoice_po, $invoice_to_company, $invoice_to_company_address, $invoice_message_top, $invoice_message_bottom, $sub_total_text, $sales_tax_text, $sales_tax, $g_total_text, $invoice_total, $invoice_paid, $invoice_status, $invoice_created_by, $invoice_to_company_id);
            $query->execute($values);
        }
        return $this->link->lastInsertId();
    }

    function insertItems($item_description, $quantity, $unit_price, $total, $invoice_refrence_id) {
        $query = $this->link->prepare("INSERT INTO invoice_items (item_description,quantity,unit_price,total,invoice_refrence_id)
				VALUES (?,?,?,?,?)
			");
        $values = array($item_description, $quantity, $unit_price, $total, $invoice_refrence_id);
        $query->execute($values);
        return $query->rowCount();
    }

    function listInvoice($login_username, $param = null, $start_range = null, $end_range = null) {
        if (isset($start_range)) {
            if (isset($param)) {
                foreach ($param as $key => $value) {
                    $query = $this->link->query("SELECT * FROM invoices WHERE $key = '$value' AND invoice_created_by = '$login_username'  AND invoice_created_on BETWEEN '$start_range' AND '$end_range'  ORDER BY id DESC");
                }
            } else {
                $query = $this->link->query("SELECT * FROM invoices WHERE invoice_created_by = '$login_username'  AND invoice_created_on BETWEEN '$start_range' AND '$end_range' ORDER BY id DESC");
            }
        } else {
            if (isset($param)) {
                foreach ($param as $key => $value) {
                    $query = $this->link->query("SELECT * FROM invoices WHERE $key = '$value' AND invoice_created_by = '$login_username' ORDER BY id DESC");
                }
            } else {
                $query = $this->link->query("SELECT * FROM invoices WHERE invoice_created_by = '$login_username' ORDER BY id DESC");
            }
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function listInvoiceItems($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("SELECT * FROM invoice_items WHERE $key = '$value' ORDER BY id DESC");
            }
        } else {
            $query = $this->link->query("SELECT * FROM invoice_items ORDER BY id DESC");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function deleteInvoiceItems($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("DELETE FROM invoice_items WHERE $key = '$value'");
            }
        }
        return $query->rowCount();
    }

    function deleteInvoice($param = null) {
        if (isset($param)) {
            foreach ($param as $key => $value) {
                $query = $this->link->query("DELETE FROM invoices WHERE $key = '$value'");
            }
        }
        return $query->rowCount();
    }

    function updateInvoiceInfo($param, $where) {
        foreach ($param as $key => $value) {
            $query = $this->link->query("UPDATE invoices SET $key = '$value' WHERE id = '$where'");
        }
        return $query->rowCount();
    }

}
?>

