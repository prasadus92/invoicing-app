<?php
if (file_exists('config.php')) {
    
} else {
    header("location: install.php");
}
?>
<?php
include_once( 'header.php' );
include_once( 'libs/manageIndex.php' );
?>
<div id="content">
    <div class="row" id="inner_content">
        <div class="twelve">
            <div id="dashboard_container">
                <div id="dashboard_container_head">
                    <a href="" class="datepicker_dropdown"> <?php echo $start_range; ?> - <?php echo $end_range; ?> </a>
                    <div id="date_picker_wrapper" class="ps_left hidden">
                        <input type="text" id="from" name="from" value="<?php echo $start_range; ?>"/> <span>to</span>
                        <input type="text" id="to" name="to" value="<?php echo $end_range; ?>"/>
                        <a href="#" id="date_picket_go" class="button success"> Go </a>
                    </div><!-- end date_picker_wrapper -->
                </div><!-- end dashboard_container_head -->
                <div id="key_figures">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="figures_container">
                                        <div id="figures_label">
                                            Invoices Total
                                        </div>
                                        <div id="figures_value">
                                            <span class="circle">
<?php echo $invoice_all_total_display; ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="figures_container">
                                        <div id="figures_label">
                                            Paid Invoices Total
                                        </div>
                                        <div id="figures_value">
                                            <span class="circle"><?php echo $invoice_paid_total_display; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="figures_container">
                                        <div id="figures_label">
                                            Pending Amount
                                        </div>
                                        <div id="figures_value">
                                            <span class="circle"><?php echo $invoice_pending_total; ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- end key_figures -->

            </div><!-- end dashboard_container -->
        </div><!-- end twelve -->
    </div><!-- end row -->
</div><!-- end content -->

<div id="content">
    <div class="row" id="inner_content">
        <div class="twelve columns widgets">
            <h2 class="widget_head"> <ul class="fl_right" style="margin-top: 30px; padding-right: 15px;"> Clients Created Between <?php echo $start_range . ' AND ' . $end_range; ?> </ul></h2>
            <div class="widget_body">
                <table class="datatables">
<?php if ($selected_clients !== 0) { ?>
                        <thead>
                            <tr>
                                <th> Client Name </th>
                                <th> Client Email </th>
                                <th> Client Website </th>
                                <th> Actions </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($selected_clients as $lc) {
                                ?>
                                <tr>
                                    <td><?php echo $lc['client_name']; ?></td>
                                    <td><?php echo $lc['client_email_address']; ?></td>
                                    <td><?php echo $lc['client_website']; ?></td>
                                    <td class="actions"> <a href="client.php?client_id=<?php echo base64_encode($lc['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_edit.png" /></a><a href="list_clients.php?delete=<?php echo base64_encode($lc['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_delete.png" /></a> <a href="create_vcard.php?client_id=<?php echo base64_encode($lc['id']); ?>"> <img src="http://cdn1.iconfinder.com/data/icons/spirit20/file-pdf.png"/></a></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td> <h2 style="text-align:center;font-size: 22px;margin:0px; padding:20px;"> NO RECENT ACTIVITY</h2> </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="content">
    <div class="row" id="inner_content">
        <div class="twelve columns widgets fl_right">
            <h2 class="widget_head"> <ul class="fl_right" style="margin-top: 30px; padding-right: 15px;"> Invoices Created Between <?php echo $start_range . ' AND ' . $end_range; ?> </ul></h2>
            <div class="widget_body">
                <table class="datatables">
<?php if ($selected_invoices !== 0) { ?>
                        <thead>
                            <tr>
                                <th> Invoice Title </th>
                                <th> Invoice To Company </th>
                                <th> Invoice Total </th>
                                <th> Invoice Status </th>
                                <th> Actions </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($selected_invoices as $lN) {
                                $invoice_total = $lN['invoice_total'];
                                $invoice_paid = $lN['invoice_paid'];
                                $invoice_percentage = $invoice_paid * 100 / $invoice_total;
                                $invoice_percentage = round($invoice_percentage, 2);
                                ?>
                                <tr>
                                    <td><?php echo $lN['invoice_title']; ?></td>
                                    <td><?php echo $lN['invoice_to_company']; ?></td>
                                    <td><?php
                                        if ($connect_default_currency_type == 'Hprepend' || $connect_default_currency_type == 'Fprepend') {
                                            echo $refrence_currency . ' ' . $lN['invoice_total'];
                                        } else {
                                            echo $lN['invoice_total'] . ' ' . $refrence_currency;
                                        }
                                        ?></td>
                                    <td>
                                        <div class="radius progress success twelve"><span class="meter" style="width:<?php echo $invoice_percentage; ?>%"></span><span class="text"><?php echo $lN['invoice_status']; ?></span></div>
                                    </td>

                                    <td class="actions"> <a href="invoice.php?invoice_id=<?php echo base64_encode($lN['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_edit.png" /></a><a href="list_invoices.php?delete=<?php echo base64_encode($lN['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_delete.png" /></a> <a href="create_pdf.php?invoice_id=<?php echo base64_encode($lN['id']); ?>&&output"><img src="http://cdn1.iconfinder.com/data/icons/spirit20/file-pdf.png"/></a></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td> <h2 style="text-align:center;font-size: 22px;margin:0px; padding:20px;"> NO RECENT ACTIVITY</h2> </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<center>
    <div style="padding-top: 10px; padding-bottom: 10px; background-color: #007600; border-top-left-radius: 6px; border-top-right-radius: 6px; font-family: verdana, cambria, 'sans-serif'; font-weight: bold; font-size: 14px; color: #CCCC7A">Developed by Prasad U S <br /><br />
        <a href="http://in.linkedin.com/in/prasadus">

            <img src="http://s.c.lnkd.licdn.com/scds/common/u/img/webpromo/btn_viewmy_160x33.png" width="160" height="33" border="0" alt="View Prasad U S's profile on LinkedIn">

        </a>
    </div>
</center>

</body>
</html>
