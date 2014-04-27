<?php

ob_start();
include_once( 'core/class.ManageInvoice.php' );
include_once( 'libs/session.php' );
include_once("MPDF54/mpdf.php");
$invoice_init = new ManageInvoice;

if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];

    $listInvoice = $invoice_init->listInvoice($logged_in_user, array('id' => base64_decode($invoice_id)));
    $invoice_items = $invoice_init->listInvoiceItems(array('invoice_refrence_id' => $invoice_id));

    if ($listInvoice !== 0) {
        include_once( 'core/class.ManageUsers.php' );
        $generate_settings_init = new ManageUsers;
        $get_setting_init_info = $generate_settings_init->getUserInfo(array('username' => $logged_in_user));
        if ($get_setting_init_info !== 0) {
            foreach ($get_setting_init_info as $userFinalInfo) {
                $watermark_type = $userFinalInfo['watermark_invoice'];
                $watermark_text = $userFinalInfo['watermark_text'];
                $watermark_image = $userFinalInfo['watermark_image'];
                $default_currency_format = $userFinalInfo['default_currency_format'];
                $default_currency_invoice = $userFinalInfo['default_currency_invoice'];
                $show_logo_invoice = $userFinalInfo['show_logo_invoice'];
                $company_logo = $userFinalInfo['company_logo'];
                $show_pdf_footer = $userFinalInfo['show_pdf_footer'];
                $pdf_footer_text = $userFinalInfo['pdf_footer_text'];
            }
        }
        if ($show_logo_invoice == 'Yes') {
            $refrence_logo = '<img src="uploads/' . $company_logo . '" />';
        } else {
            $refrence_logo = '';
        }

        foreach ($listInvoice as $invoiceInfo) {
            $your_company_name = $invoiceInfo['your_company_name'];
            $your_street = $invoiceInfo['your_street'];
            $your_city_name = $invoiceInfo['your_city_name'];
            $your_state_name = $invoiceInfo['your_state_name'];
            $your_contact_no = $invoiceInfo['your_contact_no'];
            $your_email = $invoiceInfo['your_email'];
            $invoice_title = $invoiceInfo['invoice_title'];
            $invoice_date = $invoiceInfo['invoice_date'];
            $invoice_no = $invoiceInfo['invoice_no'];
            $invoice_po = $invoiceInfo['invoice_po'];
            $invoice_to_company = $invoiceInfo['invoice_to_company'];
            $invoice_to_company_id = $invoiceInfo['invoice_to_company_id'];
            $invoice_to_company_address = str_replace('<br />', '<br />', $invoiceInfo['invoice_to_company_address']);
            $invoice_message_top = $invoiceInfo['invoice_message_top'];
            $invoice_message_bottom = $invoiceInfo['invoice_message_bottom'];
            $sub_total_text = $invoiceInfo['sub_total_text'];
            $sales_tax_text = $invoiceInfo['sales_tax_text'];
            $sales_tax = $invoiceInfo['sales_tax'];
            $g_total_text = $invoiceInfo['g_total_text'];
            $invoice_total = $invoiceInfo['invoice_total'];
        }

        if ($invoice_items !== 0) {
            $x = 1;
            $items_output = '<div id="invoice_item">
						<table class="items" autosize="2">
							<tbody>
							<tr>
								<td style="padding:5px; font-weight:bold;">S.No</td>
								<td style="padding:5px; font-weight:bold;">Item Description</td>
								<td style="padding:5px; font-weight:bold;">Quantity</td>
								<td style="padding:5px; font-weight:bold;">Unit Price</td>
								<td style="padding:5px; font-weight:bold;">Total</td>
							</tr>';

            foreach ($invoice_items as $items) {
                $items_output .= '
						<tr>
							<td style="padding:5px;">' . $x . '</td>
							<td style="padding:5px;">' . $items['item_description'] . '</td>
							<td style="padding:5px;">' . $items['quantity'] . '</td>
							<td style="padding:5px;">' . $items['unit_price'] . '</td>
							<td style="padding:5px;"><span class="item_total noteditable">' . $items['total'] . '</span></td>
						</tr>';
                $sub_total_for_items[] = $items['quantity'];
                $x++;
            }

            $items_total = array_sum($sub_total_for_items);
            $tax_total = $items_total * $sales_tax / 100;

            if ($default_currency_format == 'Hprepend' || $default_currency_format == 'Fprepend') {
                $print_sub_total = $default_currency_invoice . ' ' . $items_total;
                $print_sales_tax_total = $default_currency_invoice . ' ' . $tax_total;
                $print_grand_total = $default_currency_invoice . '' . $invoice_total;
            } else {
                $print_sub_total = $items_total . '' . $default_currency_invoice;
                $print_sales_tax_total = $tax_total . '' . $default_currency_invoice;
                $print_grand_total = $invoice_total . '' . $default_currency_invoice;
            }

            $items_output .= '</tbody>
				<tfoot>
					<tr style="background:#eee; border-bottom: 1px solid #ccc;">
						<th class="span-20" colspan="4" style="text-align:left; padding:5px;text-align:left;">
							' . $sub_total_text . '
						</th>
						<th id="formsubtotal" class="span-4 noteditable" style="text-align:left;">' . $print_sub_total . '</th>
					</tr>
					<tr style="background:#eee; border-bottom: 1px solid #ccc;">
						<th class="span-20" colspan="4" style="text-align:left; padding:5px;text-align:left;">
							' . $sales_tax_text . '
						</th>
						<th id="formtax" class="span-4 noteditable" style="text-align:left;">' . $print_sales_tax_total . '</th>
					</tr>
					<tr style="background:#eee; border-bottom: 1px solid #ccc;">
						<th class="span-20" colspan="4" style="text-align:left; padding:5px;text-align:left;">
							' . $g_total_text . '
						</th>
						<th id="formgrandtotal" class="span-4 noteditable" style="text-align:left;">' . $print_grand_total . '</th>
					</tr>
				</tfoot>
				</table></div>';
        }

        $body = '
		<html>
		<head>
			<meta charset="ISO-8859-1" />
			<style type="text/css">
			.right{
				float: right;
				width: 200px;
			}
			body {
				font-family: "Helvetica Neue", Arial, sans-serif;
			}
			#invoice_form{
				margin: auto;
				opacity: 0.99;
				width: 82%;
				min-height: 900px;
				padding: 25px 34px;
				overflow: hidden;
				margin-top: 50px;
				margin-bottom: 50px;
			}
			.bold{
				font-size: 22px;
				font-weight: bold;
				height: 56px;
				line-height: 56px;
			}
			.semi-bold{
				font-size: 18px;
				font-weight: bold;
			}
			#align_right{
				text-align: right;
			}
			.ll:focus {
				background: -webkit-gradient(linear, left top, right top, from(rgba(255,255,100,0.5)), to(rgba(255,255,100,0.2)))!important;
			}
			.rr:focus {
				background: -webkit-gradient(linear, right top, left top, from(rgba(255,255,100,0.5)), to(rgba(255,255,100,0.2)))!important;
			}
			.noteditable {
				text-indent: 10px;
			}
			.noteditable:hover {
				text-shadow: white 1px 1px;
				cursor: not-allowed;
			}
			#invoice_title{
				font-size: 35px;
				font-weight: bold;
				height: 50px;
				margin-bottom: 0;
				text-align: right;
				width: 90%;
			}
			#header{
				padding-bottom: 40px;
			}
			hr{
				background: none repeat scroll 0 0 #DDDDDD;
				border: medium none;
				clear: both;
				color: #DDDDDD;
				float: none;
				height: 1px;
				margin: 0 0 1.45em;
				width: 100%;
			}
			table tbody tr td,th{
			   border-right: 1px solid #ccc;
			}
			table tbody tr td{
				padding: 0px;
			}
			.item_total{
				display: inline-block;
				padding-left: 0px;
				padding-top: 4px;
			}
			.unstyle{
				width: 100%;
				border-collapse: collapse;
			}
			table.unstyle tbody tr td, th {
				border: none;
				width: 50%;
				padding-bottom: 10px;
			}
			.align_right{
				text-align: right;
			}
			#invoice_item{
				margin-top: 30px;
				margin-bottom: 30px;
			}
			table.items{
				border-collapse: collapse;
			}
			table.items tr{
				background: #f9f9f9;
				border: 1px solid #ccc;
			}
			</style>
			</head>
			<body>
				<div id="invoice_wrapper">
						<div id="invoice_form">
							' . $refrence_logo . '
							<br /><br />
							<div id="header" class="clearfix">
								<table class="unstyle">
									<tbody>
										<tr>
											<tr>
												<td><div class="bold">' . $your_company_name . '</div></td>
												<td class="align_right"><div class="bold" id="invoice_title">' . $invoice_title . '</div></td>
											</tr>
	
											<tr>
												<td><div>' . $your_street . '</div></td>
												<td class="align_right"><div>
													' . $invoice_date . '
												</div></td>
											</tr>
											<tr>
												<td><div>' . $your_city_name . '</div></td>
												<td class="align_right">									<div>
													' . $invoice_no . '
												</div></td>
											</tr>
											<tr>
												<td><div>' . $your_state_name . '</div></td>
												<td class="align_right">									<div>
													' . $invoice_po . '
												</div></td>
											</tr>
											<tr>
												<td><div>' . $your_contact_no . '</div></td>
												<td class="align_right">									<div>
													' . $invoice_to_company . '
												</div></td>
											</tr>
											<tr>
												<td><div>' . $your_email . '</div></td>
												<td class="align_right">									<div>
													' . $invoice_to_company_address . '
												</div></td>
											</tr>
									</tbody>
								</table>
							</div><!-- end header -->
							<hr>
							<div id="content">
								<div id="message_welcome" style="text-align: justify;">
								' . $invoice_message_top . '
								</div>
								' . $items_output . '
								<div id="invoice_footer">
								' . $invoice_message_bottom . '
								</div><!-- end invoice_footer -->
							</div><!-- end content -->
						</div>
						</div><!-- end invoice_wrapper -->	</body></html>';

        $mpdf = new mPDF();
        if ($watermark_type == 'Image Watermark') {
            $mpdf->SetWatermarkImage('uploads/' . $watermark_image);
            $mpdf->showWatermarkImage = true;
        } elseif ($watermark_type == 'Text Watermark') {
            $mpdf->SetWatermarkText($watermark_text);
            $mpdf->showWatermarkText = true;
        }

        if ($show_pdf_footer == 'Yes') {
            $mpdf->SetFooter($pdf_footer_text);
            $mpdf->defaultfooterfontsize = 10;
            $mpdf->defaultfooterfontstyle = 'B';
            $mpdf->defaultfooterline = 0;
        }
        $mpdf->WriteHTML($body);
        $mpdf->Output($invoice_id . '_invoice.pdf');

        if (isset($_GET['output'])) {
            header('Content-Type: application/pdf');
            header('Content-disposition: attachment;filename=' . $invoice_id . '_invoice.pdf');
            readfile($invoice_id . '_invoice.pdf');
            unlink($invoice_id . '_invoice.pdf');
        }
//			exit;
    }
}
?>