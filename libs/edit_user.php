<?php

if ($_POST) {
    include_once( '../core/class.ManageUsers.php' );
    $users_init = new ManageUsers;

    $register_username = $_POST['register_username'];
    $register_email = $_POST['register_email'];
    $register_password = $_POST['register_password'];
    $user_role = $_POST['user_role'];
    $user_status = $_POST['user_status'];
    $refrence_id = $_POST['refrence_id'];
    $refrence_email = $_POST['refrence_email'];

    if (empty($register_username) || empty($register_email)) {
        echo 'All fields are required';
    } else {
        if ($register_username !== $refrence_id) {
            $find_username = $users_init->getUserInfo(array('username' => $register_username));
        } else {
            $find_username = 0;
        }

        if ($find_username == 0) {
            if ($register_email !== $refrence_email) {
                $find_email = $users_init->getUserInfo(array('email' => $register_email));
            } else {
                $find_email = 0;
            }

            if ($find_email == 0) {
                if ($register_password == '') {
                    $param = array('username' => $register_username, 'email' => $register_email, 'user_role' => $user_role, 'user_status' => $user_status);
                } else {
                    $param = array('username' => $register_username, 'email' => $register_email, 'user_role' => $user_role, 'user_status' => $user_status, 'password' => md5($register_password));
                }
                $edit_user = $users_init->updateUserInfo($param, $refrence_id);
                echo 'true';
            } else {
                echo 'Email already exists';
            }
        } else {
            echo 'Username already taken';
        }
    }
}
?>