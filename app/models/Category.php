<?php

namespace Altum\Models;

use Altum\Database\Database;
use Altum\Date;

class Category extends Model {

    public function get_category_by_store_id_and_url($store_id, $url) {

        /* Get the category */
        $category = null;

        /* Try to check if the store posts exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('s_category?store_id=' . $store_id . '&url=' . $url);

        /* Set cache if not existing */
        if(is_null($cache_instance->get())) {

            /* Get data from the database */
            $category = Database::$database->query("SELECT * FROM `categories` WHERE `store_id` = {$store_id} AND `url` = '{$url}'")->fetch_object() ?? null;

            \Altum\Cache::$adapter->save(
                $cache_instance->set($category)->expiresAfter(86400)->addTag('store_id=' . $store_id)
            );

        } else {

            /* Get cache */
            $category = $cache_instance->get();

        }

        return $category;

    }

    public function get_categories_by_store_id_and_menu_id($store_id, $menu_id) {

        /* Get the store posts */
        $categories = [];

        /* Try to check if the store posts exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('r_categories?store_id=' . $store_id . '&menu_id=' . $menu_id);

        /* Set cache if not existing */
        if(is_null($cache_instance->get())) {

            /* Get data from the database */
            $categories_result = Database::$database->query("
                SELECT 
                    *
                FROM 
                    `categories` 
                WHERE 
                    `store_id` = {$store_id}
                    AND `menu_id` = {$menu_id} 
                    AND `is_enabled` = 1
            ");
            while($row = $categories_result->fetch_object()) $categories[] = $row;

            \Altum\Cache::$adapter->save(
                $cache_instance->set($categories)->expiresAfter(86400)->addTag('store_id=' . $store_id)
            );

        } else {

            /* Get cache */
            $categories = $cache_instance->get();

        }

        return $categories;

    }

}
