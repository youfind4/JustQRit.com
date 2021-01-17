<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Title;

class Orders extends Controller {

    public function index() {

        Authentication::guard();

        $store_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$store = Database::get('*', 'stores', ['store_id' => $store_id, 'user_id' => $this->user->user_id])) {
            redirect('dashboard');
        }

        /* Genereate the store full URL base */
        $store->full_url = (new \Altum\Models\Store())->get_store_full_url($store, $this->user);

        /* Prepare the paginator */
        $total_rows = Database::$database->query("SELECT COUNT(*) AS `total` FROM `orders` WHERE `store_id` = {$store->store_id}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, 25, $_GET['page'] ?? 1, url('orders/' . $store->store_id . '?page=%d')));

        /* Get the payments list for the user */
        $orders = [];
        $pending_orders = 0;
        $orders_result = Database::$database->query("SELECT * FROM `orders` WHERE `store_id` = {$store->store_id} ORDER BY `order_id` DESC LIMIT {$paginator->getSqlOffset()}, {$paginator->getItemsPerPage()}");
        while($row = $orders_result->fetch_object()) {
            $orders[] = $row;

            if(!$row->status) {
                $pending_orders++;
            }
        }

        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Delete Modal */
        $view = new \Altum\Views\View('store/store_delete_modal', (array) $this);
        \Altum\Event::add_content($view->run(), 'modals');

        /* Establish the account sub menu view */
        $data = [
            'store_id' => $store->store_id,
            'external_url' => $store->full_url
        ];
        $app_sub_menu = new \Altum\Views\View('partials/app_sub_menu', (array) $this);
        $this->add_view_content('app_sub_menu', $app_sub_menu->run($data));

        /* Set a custom title */
        Title::set(sprintf($this->language->orders->title, $pending_orders, $store->name));

        /* Prepare the View */
        $data = [
            'store' => $store,
            'orders' => $orders,
            'pagination' => $pagination
        ];

        $view = new \Altum\Views\View('orders/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
