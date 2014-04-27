<?php

ob_start();
include_once( 'core/class.ManageClients.php' );
include_once( 'libs/session.php' );
include_once("MPDF54/mpdf.php");
$client_init = new ManageClients;

if (isset($_GET['client_id'])) {
    $get_client_info = $client_init->listClients($logged_in_user, array('id' => base64_decode($_GET['client_id'])));
    if ($get_client_info !== 0) {
        foreach ($get_client_info as $clientInfo) {
            $client_business_name = $clientInfo['client_business_name'];
            $client_tagline = $clientInfo['client_tagline'];
            $about_client = $clientInfo['about_client'];
            $client_name = $clientInfo['client_name'];
            $client_email_address = $clientInfo['client_email_address'];
            $client_contact_no = $clientInfo['client_contact_no'];
            $client_address = $clientInfo['client_address'];
            $client_website = $clientInfo['client_website'];
            $refrence_client_logo = $clientInfo['client_logo'];
        }

        if ($refrence_client_logo !== '' && $refrence_client_logo !== 'default_client.png') {
            $preview_logo = '<img src="uploads/' . $refrence_client_logo . '" style="width:130px; height:130px"/>';
        } else {
            $preview_logo = '';
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
				background: #222;
				color: #fff;
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
				border-collapse: collapse;
			}
			table.unstyle tbody tr td, th {
				border: none;
				padding-bottom: 20px;
			}
			.align_right{
				text-align: right;
			}
			#invoice_item{
				margin-top: 30px;
				margin-bottom: 30px;
			}
			h2{
				margin:0px;
			}
			table.items{
				border-collapse: collapse;
			}
			table.items tr{
				background: #f9f9f9;
				border: 1px solid #ccc;
			}
			td.sidebar{
				background: url("http://quanticalabs.com/Cascade/Template/image/tab/green_people.png") repeat scroll 0 0 transparent;
				border: 7px solid #000000;
				font-weight: bold;
				padding: 20px;
			}
			</style>
			</head>
			<body>
			<div id="invoice_wrapper">
				<div id="invoice_form">
					<table>
						<tr>
							<td class="sidebar">
								<table class="unstyle">
									<tbody>
										<tr>
											<td>' . $preview_logo . '</td>
										</tr>
										<tr>
											<td>' . $client_name . '</td>
										</tr>
										<tr>
											<td>' . $client_email_address . '</td>
										</tr>
										<tr>
											<td>' . $client_contact_no . '</td>
										</tr>
										<tr>
											<td>' . $client_website . '</td>
										</tr>
										<tr>
											<td>' . $client_address . '</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="border:none; padding-left: 30px;">
								<table class="unstyle" style="margin-top:-180px;">
									<tbody>
										<tr>
											<td class="half_more"><h2 class="extrabold">' . $client_business_name . '</h2></td>
										</tr>
										<tr>
											<td class="half_more">' . $client_tagline . '</td>
										</tr>
										<tr>
											<td class="half_more"><p style="line-height:30px;">' . $about_client . '</p></td>
										</tr>
									</tbody>
								</table>
							</td>
					</table>

				</div><!-- end invoiceForm -->
			</div><!-- end invoice_wrapper --></body></html>';

        $mpdf = new mPDF();
        $mpdf->WriteHTML($body);
        $mpdf->Output('vcard.pdf');
        header('Content-Type: application/pdf');
        header('Content-disposition: attachment;filename=vcard.pdf');
        readfile('vcard.pdf');
        exit;
    }
}
?>