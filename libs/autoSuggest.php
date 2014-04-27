<?php

include_once( '../core/class.ManageClients.php' );
include_once( 'session.php' );

if ($_POST) {
    $query = $_POST['query'];
    $m_clients_init = new ManageClients;
    $get_client_info = $m_clients_init->suggestClient($logged_in_user, array('client_name' => $query));

    if ($get_client_info !== 0) {
        echo '<ul>';
        foreach ($get_client_info as $clientInfo) {
            echo '<li><input type="hidden" name="auto_suggest_client_id" id="auto_suggest_client_id" value="' . base64_encode($clientInfo['id']) . '"/><input type="hidden" name="auto_suggest_client_address" id="auto_suggest_client_address" value="' . str_replace('<br />', '', $clientInfo['client_address']) . '" /><input type="hidden" name="auto_suggest_company_name" value="' . $clientInfo['client_name'] . '" id="auto_suggest_company_name"/>' . $clientInfo['client_name'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<ul>
				<li> You must create this client first <a href="client.php" target="_blank"> Create Now </a> 
				<input type="hidden" name="auto_suggest_client_address" id="auto_suggest_client_address" value="Smith and Company Address" /><input type="hidden" name="auto_suggest_company_name" value="Billed To Smith & Company" id="auto_suggest_company_name"/>
				</li>
			</ul>';
    }
}
?>