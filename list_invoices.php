<?php include_once( 'header.php' );
include_once( 'libs/listInvoice.php' );
include_once( 'libs/deleteInvoice.php' ); ?>
<div id="content">

<?php if (isset($_GET['delete'])) { ?> 

        <div class="row" id="inner_content">
            <div class="twelve" id="delete_wrapper">
                <h2> Are you sure you want to delete this invoice ?</h2>
                <a href="list_invoices.php?redirect=<?php echo $_GET['delete']; ?>" class="button alert"> Yes i want to delete </a>
                <a href="list_invoices.php" class="button success"> No it was pressed by mistake </a>
            </div>
        </div>

<?php } elseif ($_GET['status']) {
    if ($_GET['status'] == 'error') { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> Sorry we cannot delete this invoice at this moment </h2>
                    <a href="list_invoices.php" class="button success"> Go Back </a>
                </div>
            </div>
    <?php } else { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> Invoice deleted! </h2>
                    <a href="list_invoices.php" class="button success"> Go Back </a>
                </div>
            </div>

    <?php }
} else { ?>
        <div class="row">
            <div class="twelve">
                <div id="message_top">
                    <label class="semi-bold-js" style="float: left;"> Listing invoices under <span class="uppercase"> <?php echo $status_to_display; ?> </span></label>
                </div><!-- end message_top -->
            </div><!-- end twelve -->
        </div><!-- end row -->

        <div class="row" id="inner_content">
            <div class="twelve">
                <div id="render_table" class="radius_5">
                    <div id="render_table_head" class="radius_5_top_half">
                        <div class="three columns">

                        </div><!-- end five -->
                        <div class="nine columns">
                            <ul id="render_table_display_columns">
                                <a href="" class="datepicker_dropdown"> <?php echo $start_range; ?> - <?php echo $end_range; ?> </a>
                                <div id="date_picker_wrapper" class="ps_right hidden">
                                    <input type="text" id="from" name="from" value="<?php echo $start_range; ?>"/> <span>to</span>
                                    <input type="text" id="to" name="to" value="<?php echo $end_range; ?>"/>
                                    <a href="#" id="date_picket_go" class="button success"> Go </a>
                                </div><!-- end date_picker_wrapper -->
                            </ul>
                        </div><!-- end five -->
                    </div><!-- end render_table_head -->

                    <div id="render_table_body">
                        <table class="datatables">
                            <thead>
                                <tr>
                                    <th>Invoice Title</th>
                                    <th>To Company</th>
                                    <th>Invoice Total</th>
                                    <th>Amount Recieved</th>
                                    <th>Invoice Status</th>
    <?php if (!isset($_GET['user'])) { ?>
                                        <th>Actions</th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($listInvoice !== 0) {
                                    foreach ($listInvoice as $invoiceList) {
                                        $invoice_total = $invoiceList['invoice_total'];
                                        $invoice_paid = $invoiceList['invoice_paid'];
                                        $invoice_percentage = $invoice_paid * 100 / $invoice_total;
                                        $invoice_percentage = round($invoice_percentage, 2);
                                        ?>
                                        <tr>
                                            <td><?php echo $invoiceList['invoice_title']; ?></td>
                                            <td><?php echo $invoiceList['invoice_to_company']; ?></td>
                                            <td><?php if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                            echo $refrence_currency . ' ' . $invoiceList['invoice_total'];
                                        } else {
                                            echo $invoiceList['invoice_total'] . ' ' . $refrence_currency;
                                        } ?></td>
                                            <td><?php if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                echo $refrence_currency . ' ' . $invoiceList['invoice_paid'];
                            } else {
                                echo $invoiceList['invoice_paid'] . ' ' . $refrence_currency;
                            } ?></td>
                                            <td>
                                                <div class="radius progress success twelve"><span class="meter" style="width:<?php echo $invoice_percentage; ?>%"></span><span class="text"><?php echo $invoiceList['invoice_status']; ?></span></div>

                                            </td>
            <?php if (!isset($_GET['user'])) { ?>
                                                <td class="actions"> <a href="invoice.php?invoice_id=<?php echo base64_encode($invoiceList['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_edit.png" /></a><a href="list_invoices.php?delete=<?php echo base64_encode($invoiceList['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_delete.png" /></a> <a href="create_pdf.php?invoice_id=<?php echo base64_encode($invoiceList['id']); ?>&&output"><img src="http://cdn1.iconfinder.com/data/icons/spirit20/file-pdf.png"/></a></td>
            <?php } ?>
                                        </tr>
        <?php }
    } ?>
                            </tbody>
                        </table>
                    </div><!--end render_table_body -->
                </div><!-- end render_table -->
            </div><!-- end twelve -->
        </div><!-- row -->
<?php } ?>
</div><!-- end content -->