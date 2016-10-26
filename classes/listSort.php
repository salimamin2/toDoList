<?php
include 'includes/db_connect.php';
include 'Models/Items.php';

$post_name = $_POST["items"];
if ($post_name != NULL) { //the the user submitted the form

    foreach ($post_name as $i => $id):
            $items = Items::listSort($i, $id);
    endforeach;

} else
    echo "Nai Chala";

?>