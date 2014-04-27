<?php

session_start();
if (isset($_SESSION['logged_invoice_username'])) {
    $logged_in_user = $_SESSION['logged_invoice_username'];
    $logged_in_session_role = $_SESSION['logged_invoice_user_role'];
} else {
    header("location: login.php");
}
?>