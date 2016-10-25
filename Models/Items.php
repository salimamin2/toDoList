<?php
/**
 * Created by PhpStorm.
 * User: Salim
 * Date: 10/25/2016
 * Time: 11:01 AM
 */
include 'includes/paris.php';
//namespace Models\Items;


class Items extends Model
{
    public static function asc() {
        return Model::factory('Items')
            ->order_by_asc('position')
            ->find_many();
    }

    public static function create($post_name) {
            $items = Model::factory('Items')->create();
            $items->name = $post_name;
            $items->save();
        return $items;
    }

    public function update($post_name, $post_ID) {
            $items = Model::factory('Items')
                ->find_one($post_ID);
            $items->name = $post_name;
            $items->save();
        return $items;
    }

    public function listSort($i, $post_ID) {
            $items = Model::factory('Items')
                ->find_one($post_ID);
            $items->position = $i;
            $items->save();
        return $items;
    }

}