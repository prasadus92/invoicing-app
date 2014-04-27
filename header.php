<?php
ob_start();
include_once( 'libs/session.php' );
include_once( 'libs/userInfo.php' );
if (isset($_SERVER['QUERY_STRING']) && isset($_GET['start_range'])) {
    $query_string = '?' . $_SERVER['QUERY_STRING'];
    $mark = '&&';
} else {
    $mark = '?';
    $query_string = '';
}
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="ISO-8859-1" />
        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width" />
        <title>Silverstone Invoice Maker</title>

        <!-- Included CSS Files (Uncompressed) -->
        <!--
        <link rel="stylesheet" href="stylesheets/foundation.css">
        -->

        <!-- Included CSS Files (Compressed) -->
        <link rel="stylesheet" href="stylesheets/foundation.min.css">
        <link rel="stylesheet" href="stylesheets/app.css">
        <link rel="stylesheet" href="jquery_ui_datepicker/css/dark-hive/jquery-ui-1.9.0.custom.min.css" />
        <link rel="stylesheet" href="stylesheets/custom.css">

        <script src="javascripts/modernizr.foundation.js"></script>
        <!-- Included JS Files (Compressed) -->
        <script src="javascripts/jquery.js"></script>
        <script src="javascripts/foundation.min.js"></script>
        <!-- Initialize JS Plugins -->
        <script src="javascripts/app.js"></script>
        <script type="text/javascript" src="javascripts/datatables.js"></script>
        <script type="text/javascript" src="javascripts/autogrow.js"></script>
        <script type="text/javascript" src="javascripts/jquery.form.js"></script>
        <script type="text/javascript" src="jquery_ui_datepicker/js/jquery-ui-1.9.0.custom.min.js"></script>
        <script type="text/javascript" src="javascripts/custom.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.datatables').dataTable({
                    "sDom": '<"top"f>rt<"bottom"ip><"clear">'
                });
            });
        </script>

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
                                    <a class="script" href="index.php">
                                        Silverstone Invoice Maker
                                    </a>
                                </h1>
                            </li>
                            <li class="toggle-topbar"><a href="index.php"></a></li>
                        </ul>

                        <section>
                            <!-- Left Nav Section -->
                            <ul class="left">
                                <li class="divider"></li>
                                <li><a href="index.php"> Dashboard </a></li>
                                <li class="divider"></li>
                                <li class="has-dropdown">
                                    <a class="active" href="list_invoices.php">Invoices</a>
                                    <ul class="dropdown">
                                        <li><a href="invoice.php"><label for="">Create New Invoice &rarr; </label></a></li>
                                        <li> <a href="list_invoices.php">List All</a></li>
                                        <li> <a href="list_invoices.php<?php echo $query_string . $mark; ?>sort=draft">Draft Invoice</a></li>
                                        <li> <a href="list_invoices.php<?php echo $query_string . $mark; ?>sort=paid">Paid</a></li>
                                        <li> <a href="list_invoices.php<?php echo $query_string . $mark; ?>sort=Partially-Paid">Partially Paid</a></li>
                                        <li> <a href="list_invoices.php<?php echo $query_string . $mark; ?>sort=pending">Pending</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li class="has-dropdown">
                                    <a class="active" href="list_clients.php">Clients</a>
                                    <ul class="dropdown">
                                        <li><a href="client.php"><label for="">Create New Client &rarr; </label></a></li>
                                        <li> <a href="list_clients.php">List All</a></li>
                                        <li> <a href="list_clients.php?sort=pdue">Payment Due</a></li>
                                    </ul>
                                </li>
                                <?php
                                if ($logged_in_session_role == 'Admin') {
                                    echo '<li class="divider"></li>
						<li class="has-dropdown"><a href="list_users.php"> Users </a>
							<ul class="dropdown">
								<li><a href="user.php"><label for="">Create New User &rarr; </label></a></li>
								<li><a href="list_users.php"> List All </a></li>
								<li><a href="list_users.php?sort=inactive"> Inactive Users </a></li>
								<li><a href="list_users.php?sort=active"> Active Users </a></li>
							</ul>
						</li>';
                                }
                                ?>
                            </ul>

                            <!-- Right Nav Section -->
                            <ul class="right">
                                <li class="divider show-for-medium-and-up"></li>
                                <li class="has-dropdown">
                                    <a href="#">Settings</a>
                                    <ul class="dropdown">
                                        <li><a href="#" id="pop_up_settings"> Account Settings </a></li>
                                        <?php if ($logged_in_session_role == 'Admin') { ?>
                                            <li><a href="#" id="email_pop_up_settings"> Email Settings </a></li>
                                        <?php } ?>
                                        <li><a href="logout.php"> Logout </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </section></nav>
                </div><!-- end twelve -->
            </div><!-- end row -->
            <?php if (isset($_GET['success'])) {
                echo '<div id="anroid_success"> <img src="images/loader.gif" />' . $_GET['success'] . ' Successfully </div>';
            } else {
                echo '<div id="anroid_success" class="loading"> Loading Please Wait </div>';
            } ?>

<?php
if ($logged_in_session_role == 'Admin') {
    if ($user_email_settings !== 0) {
        foreach ($user_email_settings as $email_settings_value) {
            ?>
                        <div id="email_settings_dialog">
                            <div id="settings_header">
                                <ul>
                                    <li><a href="#" id=""> Email Settings </a></li>
                                </ul>
                                <a class="email_modal_close" href="#"></a>
                            </div><!-- end settings_header -->
                            <div id="settings_body">
                                <div class="form_field">
                                    <label for="Send Invoice Emails From">Send Invoice Emails From</label>
                                    <select name="invoice_emails_from" id="invoice_emails_from">
                                        <?php
                                        echo '<option value="' . $email_settings_value['invoice_emails_from_toggle'] . '">' . $email_settings_value['invoice_emails_from_toggle'] . '</option>';
                                        $rest_settings_value = array_diff($email_settings_invoice_options, array($email_settings_value['invoice_emails_from_toggle']));
                                        foreach ($rest_settings_value as $rSV) {
                                            echo '<option value="' . $rSV . '">' . $rSV . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form_field hidden" id="final_action_registration_emails">
                                    <label for="Send Registration Emails From">This Email Will Be Used To Send Invoice Emails</label>
                                    <input type="text" name="final_registration_emails" id="final_registration_emails" value="<?php echo $email_settings_value['config_company_emails_from']; ?>"/>
                                </div>

                                <div class="form_field">
                                    <label for="Send Registration Emails From">Send Registration Emails From</label>
                                    <input type="text" name="registration_emails" id="registration_emails" value="<?php echo $email_settings_value['invoice_email_from']; ?>"/>
                                </div>

                                <div class="form_field">
                                    <a href="#" id="save_email_settings" class="button success"> Save Email Settings </a>
                                </div>
                            </div>
                        </div><!-- end email_settings_dialog -->
        <?php }
    }
} ?>

            <div id="settings_dialog">
                <div id="settings_header">
                    <ul>
                        <li class="active"><a href="#" id="account_settings_tab"> Account Settings </a></li>
                        <li><a href="#" id="invoice_settings_tab"> Invoice Settings </a></li>
                        <li><a href="#" id="company_settings_tab"> Company Settings </a></li>
                    </ul>
                    <a class="modal_close" href="#"></a>
                </div><!-- end settings_header -->
                <div id="settings_body">
                    <div class="account_settings_tab header_setting_tab">
                        <?php
                        if ($userInfo !== 0) {
                            foreach ($userInfo as $listInfo) {
                                $refrence_currency = $listInfo['default_currency_invoice'];
                                $refrence_logo = $listInfo['company_logo'];
                                $show_logo_command = $listInfo['show_logo_invoice'];
                                $connect_default_currency_type = $listInfo['default_currency_format'];
                                $your_company_name = $listInfo['your_company_name'];
                                $company_street_address = $listInfo['company_street_address'];
                                $company_city = $listInfo['company_city'];
                                $company_state = $listInfo['company_state'];
                                $company_phone_no = $listInfo['company_phone_no'];
                                $company_email_address = $listInfo['email'];
                                ?>
                                <div class="form_field">
                                    <label for="Username">Email</label>
                                    <input type="text" name="email" value="<?php echo $listInfo['email']; ?>" id="email"/>
                                </div>
                                <div class="form_field">
                                    <label for="New Password">New Password</label>
                                    <input type="password" name="new_password" value="" id="new_password"/>
                                </div>
                                <div class="form_field">
                                    <label for="New Password">Repeat Password</label>
                                    <input type="password" name="new_password_repeat" value="" id="new_password_repeat"/>
                                </div>
                                <div class="form_field">
                                    <label for="Username">Currency</label>
                                    <input type="hidden" name="selected_currency" value="<?php echo $listInfo['default_currency_invoice']; ?>" id="selected_currency" />
                                    <select name="currency" id="currency">
                                        <option value="<?php echo $listInfo['default_currency']; ?>" selected="selected"><?php echo $listInfo['default_currency_text']; ?></option>
                                        <option value="USD">U.S. Dollars (&#36;)</option>
                                        <option value="CAD">Canadian Dollars (&#36;)</option>
                                        <option value="GBP">British Pounds Sterling (&pound;)</option>
                                        <option value="EUR">Euros (&euro;)</option>
                                        <option value="AUD">Australian Dollars (&#36;)</option>
                                        <option value="ARS">Argentine Pesos (&#36;)</option>
                                        <option value="BRL">Brazilian Reais (R&#36;)</option>
                                        <option value="CNY">Chinese Renminbi (�)</option>
                                        <option value="COP">Columbian Pesos ($)</option>
                                        <option value="HRK">Croatian Kuna (kn)</option>
                                        <option value="CZK">Czech Koruna (Kc)</option>
                                        <option value="DKK">Danish Kroner (kr)</option>
                                        <option value="HKD">Hong Kong Dollars (&#36;)</option>
                                        <option value="INR">Indian Rupees (Rs)</option>
                                        <option value="IDR">Indonesian Rupiah (Rp)</option>
                                        <option value="JPY">Japanese Yen (�)</option>
                                        <option value="LTL">Lithuanian Litas (Lt)</option>
                                        <option value="MYR">Malaysian Ringgit (RM)</option>
                                        <option value="MUR">Mauritian Rupees (Rs)</option>
                                        <option value="MXN">Mexican Pesos ($)</option>
                                        <option value="NZD">New Zealand Dollars (&#36;)</option>
                                        <option value="NOK">Norwegian Kroner (kr)</option>
                                        <option value="PKR">Pakistani Rupees (Rs)</option>
                                        <option value="SAR">Saudi Riyal (SR)</option>
                                        <option value="SGD">Singapore Dollars (&#36;)</option>
                                        <option value="ZAR">South African Rand (R)</option>
                                        <option value="SEK">Swedish Kronor (kr)</option>
                                        <option value="CHF">Swiss Francs (SFr)</option>
                                        <option value="TRY">Turkish Liras (TL)</option>
                                    </select>
                                </div>

                                <div class="form_field">
                                    <label for="Currency Format">Currency Format</label>
                                    <select name="currency_format" id="currency_format" style="margin-top: 2px;">
        <?php
        echo '<option value="' . $listInfo['default_currency_format'] . '" selected="selected">' . array_search($listInfo['default_currency_format'], $default_currency_format_array) . '</option>';
        foreach ($default_currency_format_array as $key => $value) {
            if ($value !== $listInfo['default_currency_format'])
                echo '<option value="' . $value . '">' . $key . '</option>';
        }
        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="invoice_settings_tab hidden header_setting_tab">
                                <div class="form_field">
                                    <label for="Show Company Logo">Show Logo</label>
                                    <select name="show_company_logo" id="show_company_logo" style="margin-top: 1px;">
        <?php
        echo '<option value="' . $listInfo['show_logo_invoice'] . '" selected="selected">' . $listInfo['show_logo_invoice'] . '</option>';
        $remaning_option = array_diff($show_logo_array, array($listInfo['show_logo_invoice']));
        foreach ($remaning_option as $listOptions) {
            echo '<option value="' . $listOptions . '">' . $listOptions . '</option>';
        }
        ?>
                                    </select>
                                </div>

                                <div class="form_field" id="show_logo_wrapper">
                                    <label for="Company Logo" style="display: block;float: none;margin-bottom: 12px;padding-top: 0;">Company Logo</label>
                                    <div class="company_logo">
                                        <form id="logo_upload_form" method="post" enctype="multipart/form-data" action="libs/upload_logo.php">
                                            <input type="file" name="input_logo" value="" id="input_logo" />
                                        </form>
                                        <div>
                                            <span id="preview"><img src="uploads/<?php echo $listInfo['company_logo']; ?>" alt="Company Logo [ image ]" id="display_logo"/></span>
                                            <span class="overlay hidden"> Click to upload a new logo ( 230 X 85 )</span>
                                        </div>
                                        <span class="loader"></span>
                                    </div><!-- end company_logo -->
                                </div>

                                <div class="form_field">
                                    <label for="Add Watermark">Watermark Invoice</label>
                                    <select name="add_watermark" id="add_watermark" style="margin-top: 2px;">
        <?php
        echo '<option value="' . $listInfo['watermark_invoice'] . '" selected="selected">' . $listInfo['watermark_invoice'] . '</option>';
        $remaning_option = array_diff($watermark_options_array, array($listInfo['watermark_invoice']));
        foreach ($remaning_option as $listOptions) {
            echo '<option value="' . $listOptions . '">' . $listOptions . '</option>';
        }
        ?>
                                    </select>
                                </div>

                                <div class="form_field hidden" id="watermark_text">
                                    <label for="Add Watermark">Watermark Text</label>
                                    <input type="text" name="watermark_text_input" id="watermark_text_input" value="<?php echo $listInfo['watermark_text']; ?>"/>
                                </div>

                                <div class="form_field hidden" id="watermark_image">
                                    <label for="Watermark Image" style="display: block;float: none;margin-bottom: 12px;padding-top: 0; width:100%;">Watermark Image</label>
                                    <div class="watermark_image_logo">
                                        <form id="watermark_upload_form" method="post" enctype="multipart/form-data" action="libs/upload_watermark.php">
                                            <input type="file" name="input_watermark" value="" id="input_watermark" />
                                        </form>
                                        <div>
                                            <span id="watermark_preview"><img src="uploads/<?php echo $listInfo['watermark_image']; ?>" alt="Company Logo [ image ]" id="display_logo"/></span>
                                            <span class="watermark_overlay hidden"> Click to upload watermark image ( Till 1 MB )</span>
                                        </div>
                                        <span class="loader"></span>
                                    </div><!-- end company_logo -->
                                </div>

                                <div class="form_field">
                                    <label for="Add PDF Footer">Add PDF Footer</label>
                                    <select name="pdf_footer_add" id="pdf_footer_add">
        <?php
        echo '<option value="' . $listInfo['show_pdf_footer'] . '" selected="selected">' . $listInfo['show_pdf_footer'] . '</option>';
        $remaining_options = array_diff($default_pdf_footer_options, array($listInfo['show_pdf_footer']));
        foreach ($remaining_options as $value) {
            echo '<option value="' . $value . '">' . $value . '</option>';
        }
        ?>
                                    </select>
                                </div>

                                <div class="form_field hidden" id="pdf_footer_text_wrapper">
                                    <label for="PDF Footer Text">PDF Footer Text</label>
                                    <input type="text" name="pdf_footer_text" value="<?php echo $listInfo['pdf_footer_text']; ?>" id="pdf_footer_text"/>
                                </div>

                            </div><!-- end settings Tab -->

                            <div class="company_settings_tab header_setting_tab hidden">
                                <div class="form_field">
                                    <label for="Your Company Name">Your Company Name</label>
                                    <input type="text" name="your_company_name_settings" value="<?php echo $your_company_name; ?>" id="your_company_name_settings"/>
                                </div>
                                <div class="form_field">
                                    <label for="Your Company Name">Street Address</label>
                                    <input type="text" name="street_address_settings" value="<?php echo $company_street_address; ?>" id="street_address_settings"/>
                                </div>
                                <div class="form_field">
                                    <label for="Your Company Name">City</label>
                                    <input type="text" name="city_settings" value="<?php echo $company_city; ?>" id="city_settings"/>
                                </div>
                                <div class="form_field">
                                    <label for="Your Company Name">State</label>
                                    <input type="text" name="state_settings" value="<?php echo $company_state; ?>" id="state_settings"/>
                                </div>
                                <div class="form_field">
                                    <label for="Your Company Name">Phone No</label>
                                    <input type="text" name="phone_no" value="<?php echo $company_phone_no; ?>" id="phone_no"/>
                                </div>
                            </div><!-- end company_settings_tab -->

                            <div class="form_field">
                                <a href="#" id="save_settings" class="button success"> Save Settings </a>
                            </div>

    <?php }
} ?>
                </div><!-- end settings_body -->
            </div><!-- end settings_dialog -->

            <div class="bck_bg"></div>
        </div><!-- end header -->
