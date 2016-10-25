<?php
include 'includes/db_connect.php';
include 'Models/Items.php';

$post_name = $_POST["NAME"];
if ($post_name != NULL) { //the the user submitted the form
    //$name = $mysqli->real_escape_string($_POST['record']);
    //echo $_POST['record'];
    $items = Items::create($post_name);
    $data = array('item' => $post_name);
    echo json_encode($data);
}
?>
        