<?php include_once( 'header.php' );
error_reporting(0);
?>
<div class="row">
    <div id="invoice_wrapper">
        <?php
        if (isset($_GET['invoice_id'])) {
            include_once( 'libs/listInvoice.php' );
            if ($listInvoice !== 0) {
                foreach ($listInvoice as $invoiceInfo) {
                    $current_invoice_status = $invoiceInfo['invoice_status'];
                    $invoice_total = $invoiceInfo['invoice_total'];
                    $invoice_paid = $invoiceInfo['invoice_paid'];
                    $invoice_percentage = $invoice_paid * 100 / $invoice_total;
                    $invoice_percentage = round($invoice_percentage, 2);
                    ?>
                    <input type="hidden" id="create_invoice_without_client" value="true" />
                    <form method="post" action="libs/create_invoice.php" id="form_invoice" name="form_invoice">
                        <input type="hidden" name="primary_id" value="<?php echo $_GET['invoice_id']; ?>" id="primary_id"/>
                        <input type="hidden" name="refrence_currency_for_pdf" value="<?php echo htmlentities($refrence_currency); ?>" />
                        <div class="logo_guide"> Change Logo From Settings Tab </div>
                        <div class="free_size">
                            <a href="#" id="add_row"> <span class="math_icon"> + </span> Add Row </a>
                            <a href="#" id="delete_row"> <span class="math_icon"> - </span> Delete Row </a>
                        </div>

                        <div id="invoice_form">
                            <div id="header" class="clearfix">
                                <div class="six columns">
                                    <?php
                                    if ($show_logo_command == 'Yes') {
                                        echo '<img src="uploads/' . $refrence_logo . '" alt="Update Company Logo" id="display_logo"/> <input type="hidden" name="refrence_logo" value="<?php echo $refrence_logo; ?>" />';
                                    }
                                    ?>
                                    <input type="" name="company_name" value="<?php echo $invoiceInfo['your_company_name']; ?>" class="bold">
                                    <div class="section">
                                        <input type="text" name="user_street" value="<?php echo $invoiceInfo['your_street']; ?>">
                                        <input type="text" name="user_city" value="<?php echo $invoiceInfo['your_city_name']; ?>">
                                        <input type="text" name="user_state" value="<?php echo $invoiceInfo['your_state_name']; ?>">
                                        <input type="text" name="user_contact_num" value="<?php echo $invoiceInfo['your_contact_no']; ?>" style="margin-top: 20px;">
                                        <input type="text" name="user_email" value="<?php echo $invoiceInfo['your_email']; ?>">
                                        <input type="hidden" name="refrence_invoice" value="<?php echo $_GET['invoice_id']; ?>" />
                                        <input type="hidden" name="generate_time_user" value="<?php echo $logged_in_user; ?>" />
                                        <input type="hidden" name="connect_default_currency_type" value="<?php echo $connect_default_currency_type; ?>" />
                                    </div><!-- end section -->

                                </div><!-- end columns -->
                                <div class="six columns" id="align_right">
                                    <input type="" name="invoice_title" value="<?php echo $invoiceInfo['invoice_title']; ?>" class="bold" id="invoice_title">
                                    <div class="section">
                                        <input type="text" name="invoice_date" value="<?php echo $invoiceInfo['invoice_date']; ?>">
                                        <input type="text" name="invoice_no" value="<?php echo $invoiceInfo['invoice_no']; ?>">
                                        <input type="text" name="invoice_po" value="<?php echo $invoiceInfo['invoice_po']; ?>">
                                        <input type="text" name="invoice_to" id="invoice_to" value="<?php echo $invoiceInfo['invoice_to_company']; ?>" style="margin-top: 20px;" class="semi-bold" autocomplete=off>
                                        <div id="client_auto_suggest" class="hidden">
                                            <div id="client_auto_suggest_head">
                                            </div>
                                            <div id="client_auto_suggest_body">
                                            </div><!-- end client_auto_suggest_body -->
                                        </div><!-- end client_auto_suggest -->
                                        <input type="hidden" name="auto_suggest_client_id" id="auto_suggest_client_id" value="<?php echo $invoiceInfo['invoice_to_company_id']; ?>"/>
                                        <textarea name="invoice_to_address" class="semi-bold" style="text-align:right;"><?php echo str_replace('<br />', '', $invoiceInfo['invoice_to_company_address']); ?></textarea>
                                    </div><!-- end section -->
                                </div><!-- end six_columns -->
                            </div><!-- end header -->
                            <hr>

                            <div id="content">
                                <div id="message_welcome">
                                    <textarea name="message"><?php echo str_replace("<br />", "", $invoiceInfo['invoice_message_top']); ?></textarea>
                                </div>

                                <div id="invoice_item">
            <?php if ($invoice_items !== 0) {
                $s = 1;
                ?>
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="50"><input type="text" name="" value="S.No" readonly class="noteditable"></th>
                                                    <th width="350"><input type="text" name="" value="Item Description" readonly class="noteditable"></th>
                                                    <th width="120"><input type="text" name="" value="Quantity" readonly class="noteditable"></th>
                                                    <th width="120"><input type="text" name="" value="Unit Price" readonly class="noteditable"></th>
                                                    <th width="120"><input type="text" name="" value="Total" readonly class="noteditable"></th>
                                                </tr>
                <?php
                foreach ($invoice_items as $listItems) {
                    $items_total[] = $listItems['total'];
                    ?>
                                                    <tr>
                                                        <td><input type="text" name="item_sno[]" value="<?php echo $s; ?>" readonly class="noteditable"></td>
                                                        <td><input type="text" name="item_description[]" value="<?php echo $listItems['item_description']; ?>"></td>
                                                        <td><input type="text" name="item_quantity[]" class="item_quantity" value="<?php echo $listItems['quantity']; ?>"></td>
                                                        <td><input type="text" name="item_price[]" class="item_price" value="<?php echo $listItems['unit_price']; ?>"></td>
                                                        <td><span class="item_total noteditable">
                                                                <?php
                                                                if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                                                    echo $refrence_currency . ' ' . $listItems['total'];
                                                                } else {
                                                                    echo $listItems['total'] . ' ' . $refrence_currency;
                                                                }
                                                                ?>
                                                            </span></td>
                                                    </tr>
                                                    <?php
                                                    $s++;
                                                }
                                            }
                                            $sub_total = array_sum($items_total);
                                            $sales_tax_total = $sub_total * $invoiceInfo['sales_tax'] / 100;
                                            $grand_total = $sub_total + $sales_tax_total;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="span-20" colspan="4">
                                                    <input value="<?php echo $invoiceInfo['sub_total_text']; ?>" name="subtotal_text">
                                                </th>
                                                <th id="formsubtotal" class="span-4 noteditable"><?php
                                                    if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                                        echo $refrence_currency . ' ' . $sub_total;
                                                    } else {
                                                        echo $sub_total . ' ' . $refrence_currency;
                                                    }
                                                    ?></th>
                                            </tr>
                                            <tr>
                                                <th class="span-20" colspan="4">
                                                    <input value="<?php echo $invoiceInfo['sales_tax_text']; ?>" id="salestax" name="sales_tax_text">
                                                </th>
                                                <th id="formtax" class="span-4 noteditable"><?php
                                                    if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                                        echo $refrence_currency . ' ' . $sales_tax_total;
                                                    } else {
                                                        echo $sales_tax_total . ' ' . $refrence_currency;
                                                    }
                                                    ?></th>
                                            </tr>
                                            <tr>
                                                <th class="span-20" colspan="4">
                                                    <input value="<?php echo $invoiceInfo['g_total_text']; ?>" name="grand_total_text">
                                                </th>
                                                <th id="formgrandtotal" class="span-4 noteditable"><?php
                                                    if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                                        echo $refrence_currency . ' ' . $grand_total;
                                                    } else {
                                                        echo $grand_total . ' ' . $refrence_currency;
                                                    }
                                                    ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- end invoice_items -->

                                <div id="invoice_footer">
                                    <input type="hidden" name="sales_tax_percen" value="<?php echo $invoiceInfo['sales_tax']; ?>" id="sales_tax_percen"/>
                                    <textarea name="final_message"><?php echo str_replace("<br />", "", $invoiceInfo['invoice_message_bottom']); ?></textarea>
                                </div><!-- end invoice_footer -->
                            </div><!-- end content -->
                        </div>
                </div><!-- end invoice_wrapper -->
            </form>

        <?php
        }
    } else {
        header("location: index.php");
    }
} else {
    ?>
    <form method="post" action="libs/create_invoice.php" id="form_invoice" name="form_invoice">
        <input type="hidden" name="refrence_currency_for_pdf" value="<?php echo htmlentities($refrence_currency); ?>" />
        <div class="logo_guide"> Change Logo From Settings Tab </div>
        <div class="free_size">
            <a href="#" id="add_row"> <span class="math_icon"> + </span> Add Row </a>
            <a href="#" id="delete_row"> <span class="math_icon"> - </span> Delete Row </a>
        </div>

        <input type="hidden" id="create_invoice_without_client" value="false" />
        <div id="invoice_form">
            <div id="header" class="clearfix">
                <div class="six columns">

    <?php
    if ($show_logo_command == 'Yes') {
        echo '<img src="uploads/' . $refrence_logo . '" alt="Update Company Logo" id="display_logo"/> <input type="hidden" name="refrence_logo" value="<?php echo $refrence_logo; ?>" />';
    }
    ?>
                    <input type="" name="company_name" value="<?php echo $your_company_name; ?>" class="bold">
                    <div class="section">
                        <input type="text" name="user_street" value="<?php echo $company_street_address; ?>">
                        <input type="text" name="user_city" value="<?php echo $company_city; ?>">
                        <input type="text" name="user_state" value="<?php echo $company_state; ?>">
                        <input type="text" name="user_contact_num" value="<?php echo $company_phone_no; ?>" style="margin-top: 20px;">
                        <input type="text" name="user_email" value="<?php echo $company_email_address; ?>">
                        <input type="hidden" name="refrence_invoice" value="" />
                        <input type="hidden" name="generate_time_user" value="<?php echo $logged_in_user; ?>" />
                        <input type="hidden" name="connect_default_currency_type" value="<?php echo $connect_default_currency_type; ?>" />
                    </div><!-- end section -->

                </div><!-- end columns -->
                <div class="six columns static_date" id="align_right">
                    <input type="" name="invoice_title" value="INVOICE" class="bold" id="invoice_title">
                    <div class="section">
                        <input type="text" name="invoice_date" value="10-Nov-2012">
                        <input type="text" name="invoice_no" value="Invoice #2013990">
                        <input type="text" name="invoice_po" value="PO 48900365">
                        <input type="text" name="invoice_to" id="invoice_to" value="Billed To Smith & Company" style="margin-top: 20px;" class="semi-bold" autocomplete=off>
                        <div id="client_auto_suggest" class="hidden">
                            <div id="client_auto_suggest_head">
                            </div>
                            <div id="client_auto_suggest_body">
                            </div><!-- end client_auto_suggest_body -->
                        </div><!-- end client_auto_suggest -->
                        <textarea name="invoice_to_address" class="semi-bold" style="text-align:right;">Smith and Company Address</textarea>
                    </div><!-- end section -->
                </div><!-- end six_columns -->
            </div><!-- end header -->
            <hr>

            <div id="content">
                <div id="message_welcome">
                    <textarea name="message" style="text-align: justify;">Dear Mr Client,

        This is our simple invoice maker which is pretty easy to use. We have nurtured the powers of PHP
        and MySQL as well as daynamic AJAX for the purpose. Here edit continuously without line breaks
        also not more than 3 lines for better invoice.
        Happy invoicing!!

        Thanks & Regards
        Name
                    </textarea>
                </div>

                <div id="invoice_item">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <th width="50"><input type="text" name="" value="S.No" readonly class="noteditable"></th>
                                <th width="350"><input type="text" name="" value="Item Description" readonly class="noteditable"></th>
                                <th width="120"><input type="text" name="" value="Quantity" readonly class="noteditable"></th>
                                <th width="120"><input type="text" name="" value="Unit Price" readonly class="noteditable"></th>
                                <th width="120"><input type="text" name="" value="Total" readonly class="noteditable"></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="item_sno[]" value="1" readonly class="noteditable"></td>
                                <td><input type="text" name="item_description[]" value=""></td>
                                <td><input type="text" name="item_quantity[]" class="item_quantity" value=""></td>
                                <td><input type="text" name="item_price[]" class="item_price" value=""></td>
                                <td><span class="item_total noteditable"></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="item_sno[]" value="2" readonly class="noteditable"></td>
                                <td><input type="text" name="item_description[]" value=""></td>
                                <td><input type="text" name="item_quantity[]" class="item_quantity" value=""></td>
                                <td><input type="text" name="item_price[]" class="item_price" value=""></td>
                                <td><span class="item_total noteditable"></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="item_sno[]" value="3" readonly class="noteditable"></td>
                                <td><input type="text" name="item_description[]" value=""></td>
                                <td><input type="text" name="item_quantity[]" class="item_quantity" value=""></td>
                                <td><input type="text" name="item_price[]" class="item_price" value=""></td>
                                <td><span class="item_total noteditable"></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="item_sno[]" value="4" readonly class="noteditable"></td>
                                <td><input type="text" name="item_description[]" value=""></td>
                                <td><input type="text" name="item_quantity[]" class="item_quantity" value=""></td>
                                <td><input type="text" name="item_price[]" class="item_price" value=""></td>
                                <td><span class="item_total noteditable"></span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="span-20" colspan="4">
                                    <input value="Subtotal" name="subtotal_text">
                                </th>
                                <th id="formsubtotal" class="span-4 noteditable"></th>
                            </tr>
                            <tr>
                                <th class="span-20" colspan="4">
                                    <input value="Salex Tax( 20% )" id="salestax" class="salestax" name="sales_tax_text">
                                </th>
                                <th id="formtax" class="formtax span-4 noteditable"></th>
                            </tr>
                            <tr>
                                <th class="span-20" colspan="4">
                                    <input value="Total" name="grand_total_text">
                                </th>
                                <th id="formgrandtotal" class="span-4 noteditable"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- end invoice_items -->

                <div id="invoice_footer">
                    <input type="hidden" name="sales_tax_percen" value="20" id="sales_tax_percen"/>
                    <textarea name="final_message">Please forward money to the mentoined account
        Account No - xxx-xxxxxxxx-xxx
        Account Holder Name - Your Name on Account
        Payment should be done within 80 days
                    </textarea>
                </div><!-- end invoice_footer -->
            </div><!-- end content -->
        </div>
    </div><!-- end invoice_wrapper -->
    </form>
<?php } ?>
</div><!-- end row -->

<div id="toolbar">
    <div class="row">
        <div class="twelve columns">
            <div class="tool_options">
                <div id="invoice_tool_options">
                    <div id="invoice_tool_options_header">Change Invoice Status</div><!-- end invoice_tool_options_header -->
                    <div id="invoice_tool_options_body">
                        <ul>
<?php
foreach ($invoice_tool_options_array as $key => $value) {
    if ($value == $current_invoice_status) {
        echo '<li><a href="#" class="current" title="' . $value . '"><input type="hidden" id="this_actual_text" value="' . $value . '" />' . $key . '</a></li>';
    } else {
        echo '<li><a href="#" title="' . $value . '"><input type="hidden" id="this_actual_text" value="' . $value . '" />' . $key . '</a></li>';
    }
}
?>
                        </ul>

                        <div id="amount_paid_invoice">
                            <label for="Enter the amount">Enter the amount</label>
                            <input type="text" name="amount_paid_invoice_partially" value="" id="amount_paid_invoice_partially"/>
                        </div><!-- end amount_paid_invoice -->

                    </div><!-- end invoice_tool_options_body -->
                </div><!-- invoice_tool_options -->

                <a href="#" class="button success" id="generate_pdf_form"> Save Invoice </a>
                        <?php if (isset($_GET['invoice_id'])) { ?>
                    <a href="create_pdf.php?invoice_id=<?php echo $_GET['invoice_id']; ?>&&output" class="button success"> Download PDF </a>
                    <a href="email.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="button"> Email To Client </a>
                    <div class="radius progress success three"><span class="meter" style="width:<?php echo $invoice_percentage; ?>%"></span><span class="text"><?php
                echo $current_invoice_status;
                if ($current_invoice_status !== 'Pending' && $current_invoice_status !== 'Draft') {
                    if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                        echo ' ( ' . $refrence_currency . ' ' . $invoice_paid . ' )';
                    } else {
                        echo ' ( ' . $invoice_paid . ' ' . $refrence_currency . ' )';
                    }
                }
                ?></span></div>
                    <a href="#" class="button alert fl_right" style="margin-top: 8px;"> Delete Invoice </a>
<?php } ?>
            </div>
        </div>
    </div>
</div><!-- end toolbar -->
</body>
</html>
