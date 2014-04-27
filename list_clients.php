<?php include_once( 'header.php' );
include_once( 'libs/listClients.php' );
include_once( 'libs/deleteClient.php' ); ?>
<div id="content">

<?php if (isset($_GET['delete'])) { ?> 

        <div class="row" id="inner_content">
            <div class="twelve" id="delete_wrapper">
                <h2> Are you sure you want to delete this client ?</h2>
                <a href="list_clients.php?redirect=<?php echo $_GET['delete']; ?>" class="button alert"> Yes i want to delete </a>
                <a href="list_clients.php" class="button success"> No it was pressed by mistake </a>
            </div>
        </div>

<?php } elseif ($_GET['status']) {
    if ($_GET['status'] == 'error') { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> Sorry we cannot delete this client at this moment </h2>
                    <a href="list_clients.php" class="button success"> Go Back </a>
                </div>
            </div>
    <?php } else { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> Client deleted ! </h2>
                    <a href="list_clients.php" class="button success"> Go Back </a>
                </div>
            </div>

    <?php }
} else { ?>

        <div class="row">
            <div class="twelve">
                <div id="message_top">
                    <label class="semi-bold-js" style="float: left;"> Listing clients under <span class="uppercase"><?php echo $clients_under; ?></span></label>
                </div><!-- end message_top -->
            </div><!-- end twelve -->
        </div><!-- end row -->

        <div class="row" id="inner_content">
            <div class="twelve">
                <div id="render_table" class="radius_5">
                    <div id="render_table_head" class="radius_5_top_half">
                        <div class="five columns">

                        </div><!-- end five -->
                        <div class="five columns">
                            <ul id="render_table_display_columns" style="height: 40px;">
                            </ul>
                        </div><!-- end five -->
                    </div><!-- end render_table_head -->

                    <div id="render_table_body">
                        <table class="datatables">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Pays On</th>
    <?php if (!isset($_GET['user'])) { ?>
                                        <th>Actions</th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
    <?php if ($listClients !== 0) {
        if (isset($_GET['sort'])) {
            $listClients = $listClients[0];
        }
        foreach ($listClients as $clientsLists) {
            ?>
                                        <tr>
                                            <td><?php echo $clientsLists['client_name'];
            if (!isset($_GET['user'])) { ?>
                                                    <span class="related_links"><a href="list_invoices.php?client=<?php echo base64_encode($clientsLists['id']); ?>"> Invoices </a></span> <?php } ?>
                                            </td>
                                            <td><?php echo $clientsLists['client_email_address']; ?></td>
                                            <td>Client pays on <?php echo $clientsLists['client_payment_date']; ?> of every month.</td>

            <?php if (!isset($_GET['user'])) { ?>
                                                <td class="actions"> <a href="client.php?client_id=<?php echo base64_encode($clientsLists['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_edit.png" /></a><a href="list_clients.php?delete=<?php echo base64_encode($clientsLists['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_delete.png" /></a></td>
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