<?php

$path = "../uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES['client_input_logo']['name'];
    $size = $_FILES['client_input_logo']['size'];
    $client_logo_id = $_POST['client_logo_id'];

    if (strlen($name)) {
        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {
            list($width, $height, $type, $attr) = getimagesize($_FILES['client_input_logo']['tmp_name']);

            if ($size < (1024 * 1024)) { // Image size max 1 MB
                $actual_image_name = time() . "." . $ext;
                $tmp = $_FILES['client_input_logo']['tmp_name'];

                if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                    include_once( 'session.php' );
                    include_once( '../core/class.ManageClients.php' );
                    $update_init = new ManageClients;
                    $update_param = array('client_logo' => $actual_image_name);
                    $update_info = $update_init->updateClientInfo($update_param, base64_decode($client_logo_id));
                    echo "<img src='uploads/" . $actual_image_name . "' class='preview' style='width:130px; height:130px;'>";
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