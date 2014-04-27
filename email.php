<?php include_once( 'header.php' );
include_once( 'libs/email_client_info.php' );
if (isset($_GET['invoice_id'])) { ?>
    <div id="content">
        <div class="row">
            <div class="five columns" id="inner_content">
                <div class="badge"><img src="images/invoice_badge.png" /></div>
                <div class="invoice_info">
    <?php if ($listInvoice !== 0) {
        foreach ($listInvoice as $invoiceLists) {
            ?>
                            <table class="email_invoice">
                                <tbody>
                                    <tr>
                                        <td>Invoice From  </td>
                                        <td><?php echo $invoiceLists['your_company_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td> Invoice Total </td>
                                        <td><?php if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                echo $refrence_currency . ' ' . $invoiceLists['invoice_total'];
            } else {
                echo $invoiceLists['invoice_total'] . ' ' . $refrence_currency;
            } ?></td>
                                    </tr>
                                    <tr>
                                        <td> Sender Email </td>
                                        <td><?php echo $company_email_address; ?></td>
                                    </tr>
                                </tbody>
                            </table>
            <?php
            $client_id = base64_decode($invoiceLists['invoice_to_company_id']);
        }
        $sender_name = $invoiceLists['your_company_name'];
    }
    ?>
                </div>
                <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" target="_blank" class="button success"> Update Invoice </a>
            </div><!-- end inner_content -->

            <div class="five columns" id="inner_content">
                <div class="badge"><img src="images/client_badge.png" /></div>
                <div class="invoice_info">
    <?php
    $get_client_info = $client_init->listClients($logged_in_user, array('id' => $client_id));
    if ($get_client_info !== 0) {
        foreach ($get_client_info as $clientInfo) {
            ?>
                            <table class="email_invoice">
                                <tbody>
                                    <tr>
                                        <td>Client Name  </td>
                                        <td><?php echo $clientInfo['client_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td> Client Default Payment Date </td>
                                        <td><?php echo $clientInfo['client_payment_date']; ?> of every month</td>
                                    </tr>
                                    <tr>
                                        <td> Send To Email </td>
                                        <td><?php echo $clientInfo['client_email_address']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php }
                    } ?>
                </div>
                <a href="client.php?client_id=<?php echo base64_encode($client_id); ?>" target="_blank" class="button success"> Update Client </a>
            </div>
        </div><!-- end row -->
    </div><!-- end content -->

    <div id="content">
        <div class="row">
            <div class="twelve columns form_wrapper" id="inner_content">
                <div id="form_wrapper">
    <?php
    if (isset($error)) {
        echo '<div class="alert-box alert">' . $error . '</div>';
    }
    if (isset($success)) {
        echo '<div class="alert-box success">' . $success . '</div>';
    }
    ?>
                    <form method="post" action="email.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" id="final_email_form" name="final_email_form">
                        <div class="field">
                            <label for="Email Subject">Email Subject</label><br />
                            <input type="text" name="email_subject" id="email_subject" value="Invoice From <?php echo $sender_name; ?>"/>
                        </div><br />
                        <div class="field">
                            <label for="Email Content">Email Content</label><br />
                            <textarea name="email_content" id="email_content" style="height:200px;"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="toolbar">
        <div class="row">
            <div class="twelve columns">
                <div class="tool_options">
                    <input type="submit" name="send_final_email" value="Send Email" id="send_final_email" class="button success"/>
                    <p class="fl_right" style="font-weight:bold;margin-top:15px;"> Above information will be used to send email with attached invoice PDF.</p>
                </div>
            </div>
        </div>
    </div><!-- end toolbar -->
<?php } ?>
</body>
</html>
