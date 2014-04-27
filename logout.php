<?php

session_start();
if (isset($_SESSION['logged_invoice_username'])) {
    session_destroy();
}
header("location: login.php");
?>