<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Title;

class OrdersStatistics extends Controller {

    public function index() {

        Authentication::guard();

        if(!$this->user->plan_settings->ordering_is_enabled) {
            redirect('dashboard');
        }

        if(isset($_GET['store_id'])) {
            $store_id = isset($_GET['store_id']) ? (int) $_GET['store_id'] : null;

            if(!$store = Database::get('*', 'stores', ['store_id' => $store_id, 'user_id' => $this->user->user_id])) {
                redirect('dashboard');
            }

            /* Genereate the store full URL base */
            $store->full_url = (new \Altum\Models\Store())->get_store_full_url($store, $this->user);

            $identifier_name = 'store';
            $identifier_key = 'store_id';
            $identifier_value = $store->store_id;
            $external_url = $store->full_url;
        }

        else if(isset($_GET['menu_id'])) {
            $menu_id = isset($_GET['menu_id']) ? (int) $_GET['menu_id'] : null;

            if(!$menu = Database::get('*', 'menus', ['menu_id' => $menu_id, 'user_id' => $this->user->user_id])) {
                redirect('dashboard');
            }

            $store = Database::get(['store_id', 'domain_id', 'url', 'currency'], 'stores', ['store_id' => $menu->store_id, 'user_id' => $this->user->user_id]);

            /* Genereate the store full URL base */
            $store->full_url = (new \Altum\Models\Store())->get_store_full_url($store, $this->user);

            $identifier_name = 'menu';
            $identifier_key = 'menu_id';
            $identifier_value = $menu->menu_id;
            $external_url = $store->full_url . $menu->url;
        }

        else if(isset($_GET['category_id'])) {
            $category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : null;

            if(!$category = Database::get('*', 'categories', ['category_id' => $category_id, 'user_id' => $this->user->user_id])) {
                redirect('dashboard');
            }

            $menu = Database::get(['menu_id', 'url'], 'menus', ['menu_id' => $category->menu_id, 'user_id' => $this->user->user_id]);

            $store = Database::get(['store_id', 'domain_id', 'url', 'currency'], 'stores', ['store_id' => $category->store_id, 'user_id' => $this->user->user_id]);

            /* Genereate the store full URL base */
            $store->full_url = (new \Altum\Models\Store())->get_store_full_url($store, $this->user);

            $identifier_name = 'category';
            $identifier_key = 'category_id';
            $identifier_value = $category->category_id;
            $external_url = $store->full_url . $menu->url . '/' . $category->url;

        } else {
            redirect('dashboard');
        }

        /* Statistics related variables */
        $start_date = isset($_GET['start_date']) ? Database::clean_string($_GET['start_date']) : null;
        $end_date = isset($_GET['end_date']) ? Database::clean_string($_GET['end_date']) : null;

        $date = \Altum\Date::get_start_end_dates($start_date, $end_date);

        /* Get the required statistics */
        $orders_items_chart = [];

        $orders_result = Database::$database->query("
            SELECT
                SUM(`quantity`) AS `ordered_items`,
                SUM(`price`) AS `value`,
                DATE_FORMAT(`datetime`, '%Y-%m-%d') AS `formatted_date`
            FROM
                 `orders_items`
            WHERE
                `{$identifier_key}` = {$identifier_value}
                AND (`datetime` BETWEEN '{$date->start_date_query}' AND '{$date->end_date_query}')
            GROUP BY
                `formatted_date`
            ORDER BY
                `formatted_date`
        ");

        /* Generate the raw chart data and save pageviews for later usage */
        while($row = $orders_result->fetch_object()) {
            $label = \Altum\Date::get($row->formatted_date, 5);

            $orders_items_chart[$label] = [
                'ordered_items' => $row->ordered_items,
                'value' => $row->value
            ];
        }

        $orders_items_chart = get_chart_data($orders_items_chart);

        /* Get ordered items */
        $result = Database::$database->query("
            SELECT
                `orders_items`.`item_id`,
                SUM(`orders_items`.`quantity`) AS `orders`,
                SUM(`orders_items`.`price`) AS `value`,
                `items`.`name`
            FROM
                 `orders_items`
            LEFT JOIN `items` ON `items`.`item_id` = `orders_items`.`item_id`
            WHERE
                `orders_items`.`{$identifier_key}` = {$identifier_value}
                AND (`orders_items`.`datetime` BETWEEN '{$date->start_date_query}' AND '{$date->end_date_query}')
                AND `orders_items`.`item_id` IS NOT NULL
            GROUP BY
                `orders_items`.`item_id`
            ORDER BY
                `orders` DESC
            LIMIT 25
        ");

        /* Store all the results from the database */
        $orders_items = [];

        while($row = $result->fetch_object()) {
            $orders_items[] = $row;
        }

        /* Delete Modal */
        $view = new \Altum\Views\View('store/store_delete_modal', (array) $this);
        \Altum\Event::add_content($view->run(), 'modals');

        /* Establish the account sub menu view */
        $data = [
            $identifier_key => $identifier_value,
            'external_url' => $external_url
        ];
        $app_sub_menu = new \Altum\Views\View('partials/app_sub_menu', (array) $this);
        $this->add_view_content('app_sub_menu', $app_sub_menu->run($data));

        /* Set a custom title */
        Title::set(sprintf($this->language->orders_statistics->title, ${$identifier_name}->name));

        /* Prepare the View */
        $data = [
            'identifier_name' => $identifier_name,
            'identifier_key' => $identifier_key,
            'identifier_value' => $identifier_value,
            'external_url' => $external_url,
            $identifier_name => ${$identifier_name},
            'store' => $store,

            'date' => $date,
            'orders_items_chart' => $orders_items_chart,
            'orders_items' => $orders_items,
        ];

        $view = new \Altum\Views\View('orders-statistics/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
