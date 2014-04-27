<?php include_once( 'header.php' );
error_reporting(0); ?>
<div id="content">
    <div class="row" id="inner_content">

        <?php
        if (isset($_GET['user_id'])) {
            include_once( 'libs/listUsers.php' );
            if ($listUsers !== 0) {
                foreach ($listUsers as $usersList) {
                    $user_role_array = array('Admin', 'User');
                    $user_status_array = array('Active', 'Inactive');

                    $user_role_difference = array_diff($user_role_array, array($usersList['user_role']));
                    $user_status_difference = array_diff($user_status_array, array($usersList['user_status']));
                    ?>
                    <div id="form_wrapper">
                        <div class="alert-box alert hidden"></div>
                        <div class="field">
                            <label for="Username">Username</label>
                            <input type="text" name="admin_form_username" id="admin_form_username" value="<?php echo $usersList['username']; ?>"/>
                            <input type="hidden" name="refrence_id" value="<?php echo $usersList['username']; ?>" id="refrence_id"/>
                            <input type="hidden" name="refrence_email" value="<?php echo $usersList['email']; ?>" id="refrence_email"/>
                        </div>
                        <div class="field">
                            <label for="Username">Email</label>
                            <input type="text" name="admin_form_email" id="admin_form_email" value="<?php echo $usersList['email']; ?>"/>
                        </div>
                        <div class="field">
                            <label for="Username">New Password</label>
                            <input type="password" name="admin_form_password" id="admin_form_password"/>
                        </div>
                        <div class="field">
                            <label for="Username">Re-Enter New Password</label>
                            <input type="password" name="admin_form_re_password" id="admin_form_re_password"/>
                        </div>
                        <div class="field">
                            <label for="Username">User Role</label>
                            <select name="admin_form_user_role" id="admin_form_user_role" class="text_field">
                                <?php
                                echo '<option value="' . $usersList['user_role'] . '">' . $usersList['user_role'] . '</option>';
                                foreach ($user_role_difference as $value) {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="Username">User Login Status</label>
                            <select name="admin_form_user_login_status" id="admin_form_user_login_status" class="text_field">
                                <?php
                                echo '<option value="' . $usersList['user_status'] . '">' . $usersList['user_status'] . '</option>';
                                foreach ($user_status_difference as $value) {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- end form_wrapper -->

        <?php }
    }
} else { ?>
            <div id="form_wrapper">
                <div class="alert-box alert hidden"></div>
                <div class="field">
                    <label for="Username">Username</label>
                    <input type="text" name="admin_form_username" id="admin_form_username"/>
                </div>
                <div class="field">
                    <label for="Username">Email</label>
                    <input type="text" name="admin_form_email" id="admin_form_email"/>
                </div>
                <div class="field">
                    <label for="Username">Password</label>
                    <input type="password" name="admin_form_password" id="admin_form_password"/>
                </div>
                <div class="field">
                    <label for="Username">Re-Enter Password</label>
                    <input type="password" name="admin_form_re_password" id="admin_form_re_password"/>
                </div>
                <div class="field">
                    <label for="Username">User Role</label>
                    <select name="admin_form_user_role" id="admin_form_user_role" class="text_field">
                        <option value="Admin"> Admin </option>
                        <option value="User"> User </option>
                    </select>
                </div>
                <div class="field">
                    <label for="Username">User Login Status</label>
                    <select name="admin_form_user_login_status" id="admin_form_user_login_status" class="text_field">
                        <option value="Active"> Active </option>
                        <option value="Inactive"> Inactive </option>
                    </select>
                </div>
            </div><!-- end form_wrapper -->
<?php } ?>
    </div>
</div><!-- end content -->

<div id="toolbar">
    <div class="row">
        <div class="twelve columns">
            <div class="tool_options">
                <?php if (isset($_GET['user_id'])) { ?>
                    <a href="#" id="admin_form_edit_user" class="button success"> Edit User </a>
                    <a href="#" id="admin_form_delete_user" class="button alert fl_right" style="margin-top: 8px;"> Delete User </a>
<?php } else { ?>
                    <a href="#" id="admin_form_register_user" class="button success"> Create User </a>
<?php } ?>
            </div>
        </div>
    </div>
</div><!-- end toolbar -->

</body>
</html>
