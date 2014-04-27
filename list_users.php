<?php include_once( 'header.php' );
include_once( 'libs/listUsers.php' );
include_once( 'libs/deleteUser.php' ); ?>
<div id="content">

<?php if (isset($_GET['delete'])) { ?> 

        <div class="row" id="inner_content">
            <div class="twelve" id="delete_wrapper">
                <h2> Are you sure you want to delete this user ?</h2>
                <a href="list_users.php?redirect=<?php echo $_GET['delete']; ?>" class="button alert"> Yes i want to delete </a>
                <a href="list_users.php" class="button success"> No it was pressed by mistake </a>
            </div>
        </div>

<?php } elseif ($_GET['status']) {
    if ($_GET['status'] == 'error') { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> Sorry we cannot delete this user at this moment </h2>
                    <a href="list_users.php" class="button success"> Go Back </a>
                </div>
            </div>
    <?php } else { ?>

            <div class="row" id="inner_content">
                <div class="twelve" id="delete_wrapper">
                    <h2> User deleted! </h2>
                    <a href="list_users.php" class="button success"> Go Back </a>
                </div>
            </div>

    <?php }
} else { ?>

        <div class="row">
            <div class="twelve">
                <div id="message_top">
                    <label class="semi-bold-js" style="float: left;"> Listing clients under <span class="uppercase"><?php echo $users_under; ?></span></label>
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
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>User Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    if ($listUsers !== 0) {
        foreach ($listUsers as $usersLists) {
            if (strtolower($usersLists['username']) !== strtolower($logged_in_user)) {
                ?>
                                            <tr>
                                                <td><?php echo $usersLists['username']; ?>
                                                    <span class="related_links"><a href="list_invoices.php?user=<?php echo base64_encode($usersLists['username']); ?>"> Invoices </a> | <a href="list_clients.php?user=<?php echo base64_encode($usersLists['username']); ?>"> Clients </a></span>
                                                </td>
                                                <td><?php echo $usersLists['email']; ?></td>
                                                <td><?php echo $usersLists['user_status']; ?></td>
                                                <td class="actions"> <a href="user.php?user_id=<?php echo base64_encode($usersLists['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_edit.png" /></a><a href="list_users.php?delete=<?php echo base64_encode($usersLists['id']); ?>"><img src="http://zicedemo.com/images/icon/icon_delete.png" /></a></td>
                                            </tr>
            <?php }
        }
    } ?>
                            </tbody>
                        </table>
                    </div><!--end render_table_body -->
                </div><!-- end render_table -->
            </div><!-- end twelve -->
        </div><!-- row -->
<?php } ?>
</div><!-- end content -->