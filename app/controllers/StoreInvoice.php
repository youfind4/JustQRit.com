<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Models\Plan;

class StoreInvoice extends Controller {

    public function index() {

        $order_id = isset($this->params[0]) ? (int) $this->params[0] : false;
        $hash = $_GET['hash'] ?? null;

        /* Get details about the order */
        if(!$order = Database::get('*', 'orders', ['order_id' => $order_id])) {
            redirect();
        }

        if(!in_array($order->processor, ['stripe', 'paypal'])) {
            redirect();
        }

        $payment_hash = md5($order->order_id . $order->order_number . $order->datetime);

        if((Authentication::check() && $order->user_id != $this->user->user_id) && $hash != $payment_hash) {
            redirect();
        }

        /* Make sure a payment exists */
        if(!$payment = Database::get('*', 'customers_payments', ['order_id' => $order->order_id])) {
            redirect();
        }

        /* Get details about the store */
        if(!$store = Database::get('*', 'stores', ['store_id' => $order->store_id])) {
            redirect();
        }

        /* Try to see if we get details from the billing */
        $store->business = json_decode($store->business);
        $payment->billing = json_decode($payment->billing);


        /* Prepare the View */
        $data = [
            'payment' => $payment,
            'order' => $order,
            'store' => $store,
        ];

        $view = new \Altum\Views\View('store-invoice/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }


}
