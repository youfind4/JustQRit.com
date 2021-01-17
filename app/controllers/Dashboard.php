<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;

class Dashboard extends Controller {

    public function index() {

        Authentication::guard();

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user($this->user, false);

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['is_enabled'], ['name'], ['datetime', 'pageviews', 'name', 'orders']));

        /* Prepare the paginator */
        $total_rows = Database::$database->query("SELECT COUNT(*) AS `total` FROM `stores` WHERE `user_id` = {$this->user->user_id} {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, 25, $_GET['page'] ?? 1, url('dashboard?' . $filters->get_get() . '&page=%d')));

        /* Get the changelog posts */
        $stores = [];
        $stores_result = Database::$database->query("
            SELECT
                *
            FROM
                `stores`
            WHERE
                `user_id` = {$this->user->user_id}
                {$filters->get_sql_where()}
            {$filters->get_sql_order_by()}
            LIMIT
                {$paginator->getSqlOffset()}, {$paginator->getItemsPerPage()}
        ");
        while($row = $stores_result->fetch_object()) {

            /* Genereate the store full URL base */
            $row->full_url = (new \Altum\Models\Store())->get_store_full_url($row, $this->user, $domains);

            $stores[] = $row;
        }

        /* Get some extra data for the widgets */
        $stores_statistics = Database::$database->query("SELECT COUNT(*) AS `stores`, SUM(`pageviews`) AS `pageviews`, SUM(`orders`) AS `orders` FROM `stores` WHERE `user_id` = {$this->user->user_id}")->fetch_object();

        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Delete Modal */
        $view = new \Altum\Views\View('store/store_delete_modal', (array) $this);
        \Altum\Event::add_content($view->run(), 'modals');

        /* Prepare the View */
        $data = [
            'stores' => $stores,
            'total_stores' => $total_rows,
            'pagination' => $pagination,
            'filters' => $filters,

            'stores_statistics' => $stores_statistics,
        ];

        $view = new \Altum\Views\View('dashboard/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
