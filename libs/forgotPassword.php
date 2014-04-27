<?php

if ($_POST) {
    include_once( '../core/class.ManageUsers.php' );
    require_once('../PHPMailer_5.2.1/class.phpmailer.php');

    $password_email = $_POST['password_email'];
    $password_m_users = new ManageUsers;
    $find_user = $password_m_users->getUserInfo(array('email' => $password_email));

    $get_email_settings = $password_m_users->getEmailSettings();
    if ($get_email_settings !== 0) {
        foreach ($get_email_settings as $value) {
            $reply_to = $value['invoice_email_from'];
            $from_email = $value['invoice_email_from'];
        }
    } else {
        $reply_to = $password_email;
        $from_email = $password_email;
    }


    if ($find_user !== 0) {
        $new_password = md5('user123');
        foreach ($find_user as $userList) {
            $subject = 'Invoice Maker Password Retrieve';
            $body = '<!DOCTYPE html>
				<html lang="en">
				<head>
					<meta charset="utf-8">
				</head>
				<body>
					<h3> Dear ' . $userList['username'] . '</h3>
					<p> Your login credentials are given below </p>
					<br />
					<table>
						<thead>
							<tr>
								<th>Username</th>
								<th>Password</th>
							</tr>
							<tr>
								<td>' . $userList['username'] . '</td>
								<td>user123</td>
							</tr>
						</thead>
					</table>
					<br />
					<p> You can change your password from the settings tab once you are logged in.</p>
					
					
				</body>
				</html>';

            $from_name = 'Invoice Maker';
            $to_email = $password_email;
            $to_name = $password_email;

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
                $update_password = $password_m_users->updateUserInfo(array('password' => $new_password), $userList['username']);
                echo "true";
            }
        }
    } else {
        echo 'Email not found';
    }
}
?>