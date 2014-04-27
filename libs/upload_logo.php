<?php

$path = "../uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES['input_logo']['name'];
    $size = $_FILES['input_logo']['size'];

    if (strlen($name)) {
        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {
            list($width, $height, $type, $attr) = getimagesize($_FILES['input_logo']['tmp_name']);

            if ($width <= 230 && $height <= 85) {
                if ($size < (1024 * 1024)) { // Image size max 1 MB
                    $actual_image_name = time() . "." . $ext;
                    $tmp = $_FILES['input_logo']['tmp_name'];

                    if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                        include_once( 'session.php' );
                        include_once( '../core/class.ManageUsers.php' );
                        $update_init = new ManageUsers;
                        $update_param = array('company_logo' => $actual_image_name);
                        $update_info = $update_init->updateUserInfo($update_param, $logged_in_user);
                        echo "<img src='uploads/" . $actual_image_name . "' class='preview'>";
                    }
                    else
                        echo "failed";
                }
                else
                    echo "Image file size max 1 MB";
            }
            else
                echo "Image size needs to less or equal to 230 x 85";
        }
        else
            echo "Invalid file format..";
    }
    else
        echo "Please select image..!";
    exit;
}
?>