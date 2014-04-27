<?php

if (isset($_GET['redirect'])) {
    include_once( 'core/class.ManageUsers.php' );
    include_once( 'session.php' );
    $user_init = new ManageUsers;

    $delete_user = $user_init->deleteUser(array('id' => base64_decode($_GET['redirect'])));
    if ($delete_invoice !== 0) {
        header("location: list_users.php?status=success");
    } else {
        header("location: list_users.php?status=error");
    }
}
?>