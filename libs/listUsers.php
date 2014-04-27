<?php

include_once( 'core/class.ManageUsers.php' );
include_once( 'session.php' );
$users_init = new ManageUsers;

if (isset($_GET['user_id'])) {
    $listUsers = $users_init->getUserInfo(array('id' => base64_decode($_GET['user_id'])));
} elseif (isset($_GET['sort'])) {
    $listUsers = $users_init->getUserInfo(array('user_status' => $_GET['sort']));
    $users_under = $_GET['sort'];
} else {
    $listUsers = $users_init->getUserInfo();
    $users_under = 'All';
}
?>