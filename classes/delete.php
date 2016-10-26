<?php
include 'includes/db_connect.php';
include 'Models/Items.php';

$post_id = $_POST["ID"];
if ($post_id != NULL) { //the the user submitted the form

    $items = Items::factory('items')
        ->where('id', $post_id)
        ->find_one();
    $items->delete();

}
?>
        