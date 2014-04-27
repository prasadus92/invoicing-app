<?php

$path = "../uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES['input_watermark']['name'];
    $size = $_FILES['input_watermark']['size'];

    if (strlen($name)) {
        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {
            list($width, $height, $type, $attr) = getimagesize($_FILES['input_watermark']['tmp_name']);

            if ($size < (1024 * 1024)) { // Image size max 1 MB
                $actual_image_name = time() . "." . $ext;
                $tmp = $_FILES['input_watermark']['tmp_name'];

                if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                    include_once( 'session.php' );
                    include_once( '../core/class.ManageUsers.php' );
                    $update_init = new ManageUsers;
                    $update_param = array('watermark_image' => $actual_image_name, 'watermark_invoice' => 'Image Watermark');
                    $update_info = $update_init->updateUserInfo($update_param, $logged_in_user);
                    echo "<img src='uploads/" . $actual_image_name . "' class='preview' style='max-width:100%;'>";
                }
                else
                    echo "failed";
            }
            else
                echo "Image file size max 1 MB";
        }
        else
            echo "Invalid file format..";
    }
    else
        echo "Please select image..!";
    exit;
}
?>