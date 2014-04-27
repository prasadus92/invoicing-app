<?php
ob_start();

include_once( 'core/class.ManageUsers.php' );
require_once('PHPMailer_5.2.1/class.phpmailer.php');

if (dirname($_SERVER['PHP_SELF']) !== '') {
    $dir = dirname($_SERVER['PHP_SELF']);
} else {
    $dir = '';
}
$complete_path = $_SERVER['HTTP_HOST'] . $dir;

$users_init = new ManageUsers;
$output = 'There was a problem sending you an email, please contact the administrator.';

if (isset($_GET['xhr'])) {
    $get_users_token = $users_init->getUserInfo(array('access_token' => $_GET['token']));
    if ($get_users_token !== 0) {
        foreach ($get_users_token as $userT) {
            $username = $userT['username'];
        }
        $update_user_status = $users_init->updateUserInfo(array('user_status' => 'Active'), $username);
        if ($update_user_status) {
            $output = 'Your account is activated now, use the below link to login to your account.';
        }
    }
} else {
    $get_users_token = $users_init->getUserInfo(array('access_token' => $_GET['token']));
    if ($get_users_token !== 0) {
        foreach ($get_users_token as $key => $value) {
            $user_email = $value['email'];
            $user_status = $value['user_status'];
            $user_name = $value['username'];
            $user_email_token = md5($user_name);
        }

        $get_email_settings = $users_init->getEmailSettings();
        if ($get_email_settings !== 0) {
            foreach ($get_email_settings as $value) {
                $reply_to = $value['invoice_email_from'];
                $from_email = $value['invoice_email_from'];
            }
        } else {
            $reply_to = $user_email;
            $from_email = $user_email;
        }

        if ($user_status != 'Active') {

            $body = '<!DOCTYPE html>
							<html lang="en">
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<h3> Dear ' . $user_name . '</h3>
								<p> Click the link below to verify your account </p><br />
								<p> <a href="' . $complete_path . '/account_activate.php?token=' . $user_email_token . '&&xhr"> Verify your email address </a></p>
								<table>
									<thead>
										<tr>
											<th>Username</th>
											<th>Password</th>
										</tr>
										<tr>
											<td>' . $user_name . '</td>
											<td>Your Choosen Password</td>
										</tr>
									</thead>
								</table>
								<br />
								<p> You can change your password from the settings tab once you are logged in.</p>
								</body>
								</html>';

            $subject = 'Activate Your Account With Silverstone Invoice Maker';
            $from_name = 'Silverstone Invoice Maker';
            $to_email = $user_email;
            $to_name = $user_email;

            $mail = new PHPMailer(); // defaults to using php "mail()"
            $mail->IsMail();
            $mail->AddReplyTo($reply_to, $from_name);
            $mail->SetFrom($from_email, $from_name);
            $mail->AddAddress($to_email, $to_name);
            $mail->Subject = $subject;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->MsgHTML($body);

            if (!$mail->Send()) {
                $output = 'There was a problem sending you an email, please contact the administrator.';
            } else {
                $output = 'Click the link we have sent you to your regsitered email in order to activate your account.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width" />
        <title>Silverstone Invoice Maker - Recover Account </title>

        <!-- Included CSS Files (Uncompressed) -->
        <!--
        <link rel="stylesheet" href="stylesheets/foundation.css">
        -->

        <!-- Included CSS Files (Compressed) -->
        <link rel="stylesheet" href="stylesheets/foundation.min.css">
        <link rel="stylesheet" href="stylesheets/app.css">
        <link rel="stylesheet" href="stylesheets/custom.css">

        <script src="javascripts/modernizr.foundation.js"></script>
        <!-- Included JS Files (Compressed) -->
        <script src="javascripts/jquery.js"></script>
        <script src="javascripts/foundation.min.js"></script>
        <!-- Initialize JS Plugins -->
        <script src="javascripts/app.js"></script>
        <!-- IE Fix for HTML5 Tags -->
        <!--[if lt IE 9]>
              <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>
        <div id="header">
            <div class="row">
                <div class="twelve columns" style="padding: 0px;">
                    <nav class="top-bar">
                        <ul>
                            <!-- Title Area -->
                            <li class="name">
                                <h1 id="logo">
                                    <a class="script">
                                        Silverstone Invoice Maker
                                    </a>
                                </h1>
                            </li>
                            <li class="toggle-topbar"><a href="#"></a></li>
                        </ul>

                        <section>
                            <ul class="right">
                                <li><a href="#" class="button success"> Signup for a new Account </a></li>
                            </ul>
                        </section>

                    </nav>
                </div><!-- end twelve -->
            </div><!-- end row -->
        </div><!-- end header -->

        <div id="content" style="padding-top: 100px;">
            <div class="row">
                <div id="login_form_wrapper">
                    <div id="login_form_inner_wrapper">
                        <div class="login_header">
                            <h3>Activate account </h3>
                        </div><!-- end login_header -->

                        <div class="login_form" style="line-height:20px;">
                            <p><?php echo $output; ?></p>
                            <a href="login.php" class="button success"> Login </a>
                        </div><!-- end login_form -->

                    </div><!-- end login_form_inner_wrapper -->
                </div><!-- end login_form_wrapper -->
            </div><!-- end row -->
        </div><!-- end content -->
