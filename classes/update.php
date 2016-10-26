<?php
include 'includes/db_connect.php';
include 'Models/Items.php';

$post_name = $_POST["NAME"];
$post_ID = $_POST["ID"];
echo $post_ID;
if ($post_name != NULL) { //the the user submitted the form
    $items = Items::update($post_name, $post_ID);

    $data = array('item' => $post_name);
    echo json_encode($data);
}

?>
        