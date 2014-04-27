<?php ob_start(); ?>
<?php
if (file_exists('config.php')) {
    
} else {
    header("location: install.php");
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
        <title>Silverstone Invoice Maker - Login </title>

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
        <script type="text/javascript" src="javascripts/login.js"></script>
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

                    </nav>
                </div><!-- end twelve -->
            </div><!-- end row -->
        </div><!-- end header -->

        <div id="content" style="padding-top: 100px;">
            <div class="row">
                <div id="login_form_wrapper">
                    <div id="login_form_inner_wrapper" class="form_wrappers">
                        <div class="login_header">
                            <h3>SIGN IN</h3>
                        </div><!-- end login_header -->
                        <form method="post" action="login.php" class="login_form">

                            <div class="alert alert-box hidden"></div>

                            <div class="field">
                                <label for="Username">Username</label>
                                <input type="text" name="session_username" value="" id="session_username" class="text_field"/>
                            </div><!-- end form_field -->
                            <div class="field">
                                <label for="Username">Password</label>
                                <input type="password" name="session_password" value="" id="session_password" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="actions">
                                <a href="#" id="login_user" class="button success fl_right"> Login </a>
                            </div>

                            <p class="forgot_password">
                                Forgot your password?
                                <a href="#" id="action_fPassword_form_inner_wrapper">Click here to reset it</a>
                                <br />
                                Don't have an account? <a href="#" id="action_register_form_inner_wrapper"> Register Here </a>
                            </p>
                        </form><!-- end login.php -->
                    </div><!-- end login_form_inner_wrapper -->

                    <div id="register_form_inner_wrapper" class="form_wrappers hidden">
                        <div class="login_header">
                            <h3>SIGN UP</h3>
                        </div><!-- end login_header -->
                        <form method="post" action="login.php" class="login_form">
                            <div class="alert alert-box hidden"></div>
                            <div class="field">
                                <label for="Username">Username</label>
                                <input type="text" name="register_username" value="" id="register_username" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="field">
                                <label for="Username">Email</label>
                                <input type="text" name="register_email" value="" id="register_email" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="field">
                                <label for="Username">Password</label>
                                <input type="password" name="register_password" value="" id="register_password" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="field">
                                <label for="Username">Password</label>
                                <input type="password" name="register_re_password" value="" id="register_re_password" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="actions">
                                <a href="#" id="register_user" class="button success fl_right"> Register </a>
                            </div>

                            <p class="forgot_password">
                                Already have an account? <a href="#" class="action_login_form_inner_wrapper"> Login Here </a>
                            </p>
                        </form><!-- end login.php -->
                    </div><!-- end login_form_inner_wrapper -->


                    <div id="fPassword_form_inner_wrapper" class="form_wrappers hidden">
                        <div class="login_header">
                            <h3>Forgot Password</h3>
                        </div><!-- end login_header -->
                        <form method="post" action="login.php" class="login_form">
                            <div class="alert alert-box hidden"></div>
                            <div class="field">
                                <label for="Username">Email</label>
                                <input type="text" name="password_email" value="" id="password_email" class="text_field"/>
                            </div><!-- end form_field -->

                            <div class="actions">
                                <a href="#" id="get_password" class="button success fl_right"> Send Password </a>
                            </div>

                            <p class="forgot_password">
                                Remember Password? <a href="#" class="action_login_form_inner_wrapper"> Login Here </a>
                            </p>
                        </form><!-- end login.php -->
                    </div><!-- end login_form_inner_wrapper -->

                </div><!-- end login_form_wrapper -->
            </div><!-- end row -->
        </div><!-- end content -->

    <center>
        <div style="padding-top: 10px; padding-bottom: 10px; background-color: #007600; border-top-left-radius: 6px; border-top-right-radius: 6px; font-family: verdana, cambria, 'sans-serif'; font-weight: bold; font-size: 14px; color: #CCCC7A">Developed by Prasad U S <br /><br />
            <a href="http://in.linkedin.com/in/prasadus">

                <img src="http://s.c.lnkd.licdn.com/scds/common/u/img/webpromo/btn_viewmy_160x33.png" width="160" height="33" border="0" alt="View Prasad U S's profile on LinkedIn">

            </a>
        </div>
    </center>