<?php include_once( 'header.php' );
error_reporting(0); ?>
<div class="row">
    <?php
    if (isset($_GET['success'])) {
        echo '<div id="anroid_success"> Client ' . $_GET['success'] . ' Successfully </div>';
    }

    if (isset($_GET['client_id'])) {
        include_once( 'libs/listClients.php' );
        if ($listClients !== 0) {
            foreach ($listClients as $clientsList) {
                if (strtolower($clientsList['client_created_by']) !== strtolower($logged_in_user)) {
                    header("lost.php");
                }
                ?>

                <div id="invoice_wrapper">

                    <div class="client_logo">
                        <form id="client_logo_upload_form" method="post" enctype="multipart/form-data" action="libs/client_upload_logo.php">
                            <input type="file" name="client_input_logo" value="" id="client_input_logo" />
                            <input type="hidden" name="client_logo_id" value="<?php echo $_GET['client_id']; ?>" />
                        </form>
                        <div>
                            <span id="client_preview"><img src="uploads/<?php echo $clientsList['client_logo']; ?>" alt="Client Logo [ image ]" id="client_display_logo" style="width:130px; height: 130px;"/></span>
                            <span class="client_overlay hidden custom_overlay"> Square Image <br />[ Example 100 x 100 ]</span>
                        </div>
                        <span class="loader"></span>
                    </div><!-- end company_logo -->

                    <form method="post" action="libs/create_vcard.php" id="create_vcard" name="create_vcard">
                        <div id="invoice_form" style="min-height:400px">
                            <div class="seven columns">
                                <div id="client_head">
                                    <div class="four columns" style="height: 150px;">
                                    </div>
                                    <div class="eight columns"><input type="text" name="client_business_name" id="client_business_name" class="extrabold" value="<?php echo $clientsList['client_business_name']; ?>" style="height:auto; line-height:auto; margin:0px;"/></h2>
                                        <input type="text" name="client_tagline" value="<?php echo $clientsList['client_tagline']; ?>" id="client_tagline" class="semi-bold-js"/>
                                    </div>
                                </div><!-- end client_head -->

                                <div class="textarea_wrapper"><textarea name="about_client"><?php echo $clientsList['about_client']; ?></textarea></div>

                                <div id="date_suggestion_wrapper">
                                    <h5> This client pays me on <input type="text" name="client_payment_date" id="client_payment_date" value="<?php echo $clientsList['client_payment_date']; ?>" class="semi-bold" style="display:inline; margin:0; width: 40px;"/> of every month </h5>
                                </div><!-- end date_suggestion_wrapper -->

                            </div><!-- end seven -->
                            <div class="four columns" id="client_sidebar">
                                <input type="text" name="client_name" value="<?php echo $clientsList['client_name']; ?>" id="client_name" class="semi-bold-js"/>
                                <input type="text" name="client_email_address" value="<?php echo $clientsList['client_email_address']; ?>" id="client_email_address" class="semi-bold-js"/>
                                <input type="text" name="client_contact_no" id="client_contact_no" value="<?php echo $clientsList['client_contact_no']; ?>" class="semi-bold-js"/>
                                <input type="text" name="client_website" id="client_website" value="<?php echo $clientsList['client_website']; ?>" class="semi-bold-js"/>
                                <input type="hidden" name="refrence_client_id" value="<?php echo $_GET['client_id']; ?>" id="refrence_client_id"/>
                                <input type="hidden" name="refrence_client_logo" id="refrence_client_logo" value="<?php echo $clientsList['client_logo']; ?>"/>
                                <textarea name="client_address" class="semi-bold-js" id="client_address"><?php echo str_replace('<br />', '', $clientsList['client_address']); ?></textarea>
                            </div><!-- end five -->
                        </div><!-- end invoiceForm -->
                    </form>
                </div><!-- end invoice_wrapper -->
        <?php }
    }
} else { ?>
        <div id="invoice_wrapper">
            <div class="client_logo">
                <div>
                    <span id="client_preview"><img src="uploads/default_client.png" alt="Client Logo [ image ]" id="client_display_logo" style="width:130px; height: 130px;"/></span>
                    <span class="client_overlay hidden custom_overlay">Upload Client Logo Once You Are Done Creating Client</span>
                </div>
            </div>
            <form method="post" action="libs/create_vcard.php" id="create_vcard" name="create_vcard">
                <div id="invoice_form" style="min-height:400px">
                    <div class="seven columns">
                        <div id="client_head">
                            <div class="four columns" style="height:150px;">
                            </div>
                            <div class="eight columns"><input type="text" name="client_business_name" id="client_business_name" class="extrabold" value="Jonathan Doe" style="height:auto; line-height:auto; margin:0px;"/></h2>
                                <input type="text" name="client_tagline" value="Client Tagline" id="client_tagline" class="semi-bold-js"/>
                            </div>
                        </div><!-- end client_head -->

                        <div class="textarea_wrapper"><textarea name="about_client">Jonathan Doe is a nice guy and his name is used by every next developer and designer in the world. There is a girl called JANE DOE she is famous too. Not sure whether they are brother sister or a love couple. Anyways i just want to let you know that this space can be used to write about your client.</textarea></div>

                        <div id="date_suggestion_wrapper">
                            <h5> This client pays me on <input type="text" name="client_payment_date" id="client_payment_date" value="10th" class="semi-bold" style="display:inline; margin:0; width: 40px;"/> of every month </h5>
                        </div><!-- end date_suggestion_wrapper -->

                    </div><!-- end seven -->
                    <div class="four columns" id="client_sidebar">
                        <input type="text" name="client_name" value="Client Name [ will be on invoice ]" id="client_name" class="semi-bold-js"/>
                        <input type="text" name="client_email_address" value="Client Email Address" id="client_email_address" class="semi-bold-js"/>
                        <input type="text" name="client_contact_no" id="client_contact_no" value="Client Contact No" class="semi-bold-js"/>
                        <input type="text" name="client_website" id="client_website" value="http://www.yourclientsite.com" class="semi-bold-js"/>
                        <textarea name="client_address" class="semi-bold-js" id="client_address">Client address [ will be on invoice ]</textarea>
                    </div><!-- end five -->
                </div><!-- end invoiceForm -->
            </form>
        </div><!-- end invoice_wrapper -->
                <?php } ?>
</div><!-- end row -->
<div id="toolbar">
    <div class="row">
        <div class="twelve columns">
            <div class="tool_options">
                <a href="#" id="saving_client" class="button success"> Save Client </a>
<?php if (isset($_GET['client_id'])) { ?>
                    <a href="create_vcard.php?client_id=<?php echo $_GET['client_id']; ?>" class="button success"> Download VCard PDF </a>
                    <a href="list_clients.php?delete=<?php echo $_GET['client_id']; ?>" class="button alert fl_right" style="margin-top: 8px;"> Delete Client </a>
<?php } ?>
            </div>
        </div>
    </div>
</div><!-- end toolbar -->

</body>
</html>
