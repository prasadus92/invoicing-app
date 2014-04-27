<?php

if ($_POST) {
    include_once( '../core/class.ManageUsers.php' );
    $users_init = new ManageUsers;
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) && empty($password)) {
        echo 'Username and password are required to login';
    } else {
        $password = md5($password);
        $login_users = $users_init->loginUser($username, $password);
        if ($login_users == 1) {
            $getLoggedInUser = $users_init->getUserInfo(array('username' => $username));
            if ($getLoggedInUser !== 0) {
                foreach ($getLoggedInUser as $userValues) {
                    $user_status = $userValues['user_status'];
                    $user_role = $userValues['user_role'];
                }
                if ($user_status == 'Active') {
                    session_start();
                    $_SESSION['logged_invoice_username'] = $username;
                    $_SESSION['logged_invoice_user_role'] = $user_role;
                    echo 'true';
                } else {
                    echo 'Your account is not active, <a href="account_activate.php?token=' . md5($username) . '" target="_blank">click here</a> activate your account';
                }
            } else {
                echo 'Something went wrong';
            }
        } else {
            echo 'Invalid Credentials';
        }
    }
}
?>