<?php

include( $_SERVER['DOCUMENT_ROOT'] . '../includes/paris.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '../includes/db_connect.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '../Models/Items.php' );


class itemsController
{
    public static function create($name)
    {
        $items = Items::create($name);
        return $items;
    }
}

?>
