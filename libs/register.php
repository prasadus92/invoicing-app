<?php

if (dirname($_SERVER['PHP_SELF']) !== '') {
    $dir = dirname($_SERVER['PHP_SELF']);
} else {
    $dir = '';
}
$complete_path = str_replace('libs', '', $_SERVER['HTTP_HOST'] . $dir);

if ($_POST) {
    include_once( '../core/class.ManageUsers.php' );
    require_once('../PHPMailer_5.2.1/class.phpmailer.php');

    $users_init = new ManageUsers;

    $register_username = $_POST['register_username'];
    $register_email = $_POST['register_email'];
    $register_password = $_POST['register_password'];

    $get_email_settings = $users_init->getEmailSettings();
    if ($get_email_settings !== 0) {
        foreach ($get_email_settings as $value) {
            $reply_to = $value['invoice_email_from'];
            $from_email = $value['invoice_email_from'];
        }
    } else {
        $reply_to = $register_email;
        $from_email = $register_email;
    }

    if (isset($_POST['user_role'])) {
        $user_role = $_POST['user_role'];
    } else {
        $user_role = 'User';
    }

    if (isset($_POST['user_status'])) {
        $user_status = $_POST['user_status'];
    } else {
        $user_status = 'Inactive';
    }

    if (empty($register_username) || empty($register_email) || empty($register_password)) {
        echo 'All fields are required';
    } else {
        $find_username = $users_init->getUserInfo(array('username' => $register_username));
        if ($find_username == 0) {
            $find_email = $users_init->getUserInfo(array('email' => $register_email));
            if ($find_email == 0) {
                $register_user = $users_init->createUser($register_username, $register_email, md5($register_password), 'USD', 'U.S. Dollars(&#36;)', '&#36;', 'Hprepend', $user_role, 'default.png', 'Yes', 'No', 'default_watermark.png', $user_status, md5($register_username), 'Your Company Name', 'Company Street Address', 'Company City', 'Company State', 'Company Phone No');
                if ($register_user == 1) {
                    if ($user_status == 'Active') {
                        echo 'true';
                    } else {
                        $subject = 'Activate Your Account With Invoice Maker';
                        $body = '<!DOCTYPE html>
							<html lang="en">
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<h3> Dear ' . $register_username . '</h3>
								<p> Click the link below to verify your account </p><br />
								<p> <a href="' . $complete_path . '/account_activate.php?token=' . md5($register_username) . '&&xhr"> Verify your email address </a></p>
								<table>
									<thead>
										<tr>
											<th>Username</th>
											<th>Password</th>
										</tr>
										<tr>
											<td>' . $register_username . '</td>
											<td>Your Choosen Password</td>
										</tr>
									</thead>
								</table>
								<br />
								<p> You can change your password from the settings tab once you are logged in.</p>
								</body>
								</html>';

                        $from_name = 'Invoice Maker';
                        $to_email = $register_email;
                        $to_name = $register_username;

                        $mail = new PHPMailer(); // defaults to using php "mail()"
                        $mail->IsMail();
                        $mail->AddReplyTo($reply_to, $from_name);
                        $mail->SetFrom($from_email, $from_name);
                        $mail->AddAddress($to_email, $to_name);
                        $mail->Subject = $subject;
                        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                        $mail->MsgHTML($body);

                        if (!$mail->Send()) {
                            echo "Email not configured, please contact administrator";
                        } else {
                            echo 'email';
                        }
                    }
                } else {
                    echo 'There was an error in registration process';
                }
            } else {
                echo 'Email already exists';
            }
        } else {
            echo 'Username already taken';
        }
    }
}
?>