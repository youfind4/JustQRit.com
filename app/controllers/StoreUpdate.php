<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Date;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Response;
use Altum\Title;

class StoreUpdate extends Controller {

    public function index() {

        Authentication::guard();

        $store_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$store = Database::get('*', 'stores', ['store_id' => $store_id, 'user_id' => $this->user->user_id])) {
            redirect('dashboard');
        }

        foreach(['details', 'socials', 'paypal', 'stripe', 'offline_payment', 'business', 'ordering'] as $key) {
            $store->{$key} = json_decode($store->{$key});
        }

        /* Genereate the store full URL base */
        $store->full_url = (new \Altum\Models\Store())->get_store_full_url($store, $this->user);

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user($this->user);

        if(!empty($_POST)) {
            $_POST['url'] = !empty($_POST['url']) ? get_slug(Database::clean_string($_POST['url'])) : false;
            $_POST['name'] = trim(Database::clean_string($_POST['name']));
            $_POST['title'] = trim(Database::clean_string($_POST['title']));
            $_POST['description'] = trim(Database::clean_string($_POST['description']));
            $_POST['address'] = trim(Database::clean_string($_POST['address']));
            $_POST['phone'] = trim(Database::clean_string($_POST['phone']));
            $_POST['website'] = trim(Database::clean_string($_POST['website']));
            $_POST['email'] = trim(Database::clean_string($_POST['email']));
            $_POST['currency'] = trim(Database::clean_string($_POST['currency']));
            $_POST['password'] = !empty($_POST['password']) ?
                ($_POST['password'] != $store->password ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $store->password)
                : null;
            $_POST['timezone']  = in_array($_POST['timezone'], \DateTimeZone::listIdentifiers()) ? Database::clean_string($_POST['timezone']) : $this->settings->default_timezone;
            $_POST['custom_css'] = trim(filter_var($_POST['custom_css'], FILTER_SANITIZE_STRING));
            $_POST['custom_js'] = trim(filter_var($_POST['custom_js'], FILTER_SANITIZE_STRING));
            $_POST['is_se_visible'] = (int) (bool) isset($_POST['is_se_visible']);
            $_POST['is_removed_branding'] = (int) (bool) isset($_POST['is_removed_branding']);
            $_POST['email_reports_is_enabled'] = (int) (bool) isset($_POST['email_reports_is_enabled']);
            $_POST['ordering_on_premise_is_enabled'] = (int) (bool) isset($_POST['ordering_on_premise_is_enabled']);
            $_POST['ordering_on_premise_minimum_value'] = (float) $_POST['ordering_on_premise_minimum_value'];
            $_POST['ordering_takeaway_is_enabled'] = (int) (bool) isset($_POST['ordering_takeaway_is_enabled']);
            $_POST['ordering_takeaway_minimum_value'] = (float) $_POST['ordering_takeaway_minimum_value'];
            $_POST['ordering_delivery_is_enabled'] = (int) (bool) isset($_POST['ordering_delivery_is_enabled']);
            $_POST['ordering_delivery_minimum_value'] = (float) $_POST['ordering_delivery_minimum_value'];
            $_POST['ordering_delivery_cost'] = (float) $_POST['ordering_delivery_cost'];
            $_POST['ordering_delivery_free_minimum_value'] = (float) $_POST['ordering_delivery_free_minimum_value'];
            $_POST['email_orders_is_enabled'] = (int) (bool) isset($_POST['email_orders_is_enabled']);

            /* Payments */
            $_POST['paypal_is_enabled'] = (bool) $_POST['paypal_is_enabled'];
            $_POST['paypal_mode'] = in_array($_POST['paypal_mode'], ['live', 'sandbox']) ? Database::clean_string($_POST['paypal_mode']) : 'sandbox';
            $_POST['paypal_client_id'] = trim(Database::clean_string($_POST['paypal_client_id']));
            $_POST['paypal_secret'] = trim(Database::clean_string($_POST['paypal_secret']));
            $_POST['stripe_is_enabled'] = (bool) $_POST['stripe_is_enabled'];
            $_POST['stripe_publishable_key'] = trim(Database::clean_string($_POST['stripe_publishable_key']));
            $_POST['stripe_secret_key'] = trim(Database::clean_string($_POST['stripe_secret_key']));
            $_POST['stripe_webhook_secret'] = trim(Database::clean_string($_POST['stripe_webhook_secret']));
            $_POST['offline_payment_is_enabled'] = (bool) $_POST['offline_payment_is_enabled'];

            /* Business */
            $_POST['business_invoice_is_enabled'] = (bool) $_POST['business_invoice_is_enabled'];
            $_POST['business_invoice_nr_prefix'] = trim(Database::clean_string($_POST['business_invoice_nr_prefix']));
            $_POST['business_name'] = trim(Database::clean_string($_POST['business_name']));
            $_POST['business_address'] = trim(Database::clean_string($_POST['business_address']));
            $_POST['business_city'] = trim(Database::clean_string($_POST['business_city']));
            $_POST['business_county'] = trim(Database::clean_string($_POST['business_county']));
            $_POST['business_zip'] = trim(Database::clean_string($_POST['business_zip']));
            $_POST['business_country'] = trim(Database::clean_string($_POST['business_country']));
            $_POST['business_email'] = trim(Database::clean_string($_POST['business_email']));
            $_POST['business_phone'] = trim(Database::clean_string($_POST['business_phone']));
            $_POST['business_tax_type'] = trim(Database::clean_string($_POST['business_tax_type']));
            $_POST['business_tax_id'] = trim(Database::clean_string($_POST['business_tax_id']));
            $_POST['business_custom_key_one'] = trim(Database::clean_string($_POST['business_custom_key_one']));
            $_POST['business_custom_value_one'] = trim(Database::clean_string($_POST['business_custom_value_one']));
            $_POST['business_custom_key_two'] = trim(Database::clean_string($_POST['business_custom_key_two']));
            $_POST['business_custom_value_two'] = trim(Database::clean_string($_POST['business_custom_value_two']));

            /* Others */
            $_POST['is_enabled'] = (int) (bool) isset($_POST['is_enabled']);

            $_POST['domain_id'] = isset($_POST['domain_id']) && isset($domains[$_POST['domain_id']]) ? (!empty($_POST['domain_id']) ? (int) $_POST['domain_id'] : null) : null;
            $_POST['is_main_store'] = (bool) isset($_POST['is_main_store']) && isset($domains[$_POST['domain_id']]) && $domains[$_POST['domain_id']]->type == 0;


            $hours = [];
            foreach([1, 2, 3, 4, 5, 6, 7] as $key) {
                $hours[$key] = [];

                $_POST['hours'][$key]['is_enabled'] = (bool) isset($_POST['hours'][$key]['is_enabled']);
                $_POST['hours'][$key]['hours'] = trim(Database::clean_string($_POST['hours'][$key]['hours']));

                $hours[$key] = [
                    'is_enabled' => $_POST['hours'][$key]['is_enabled'],
                    'hours' => $_POST['hours'][$key]['hours'],
                ];
            }

            /* Make sure the socials sent are proper */
            $socials = require APP_PATH . 'includes/s/socials.php';

            foreach($_POST['socials'] as $key => $value) {

                if(!array_key_exists($key, $socials)) {
                    unset($_POST['socials'][$key]);
                } else {
                    $_POST['socials'][$key] = Database::clean_string($_POST['socials'][$key]);
                }

            }

            /* Check for any errors */
            if(!Csrf::check()) {
                $_SESSION['error'][] = $this->language->global->error_message->invalid_csrf_token;
            }

            /* Check for duplicate url if needed */
            if(
                ($_POST['url'] && $this->user->plan_settings->custom_url_is_enabled && $_POST['url'] != $store->url)
                || ($store->domain_id != $_POST['domain_id'])
            ) {

                $domain_id_where = $_POST['domain_id'] ? "AND `domain_id` = {$_POST['domain_id']}" : "AND `domain_id` IS NULL";
                $is_existing_store = $this->database->query("SELECT `store_id` FROM `stores` WHERE `url` = '{$_POST['url']}' {$domain_id_where}")->num_rows;

                if($is_existing_store) {
                    $_SESSION['error'][] = $this->language->store->error_message->url_exists;
                }

            }

            /* Image uploads */
            $logo_allowed_extensions = ['jpg', 'jpeg', 'png', 'svg', 'gif'];
            $favicon_allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'ico'];
            $image_allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

            $logo = (!empty($_FILES['logo']['name']));
            $favicon = (!empty($_FILES['favicon']['name']));
            $image = (!empty($_FILES['image']['name']));

            /* Check for any errors on the logo image */
            if($logo) {
                $logo_file_name = $_FILES['logo']['name'];
                $logo_file_extension = explode('.', $logo_file_name);
                $logo_file_extension = strtolower(end($logo_file_extension));
                $logo_file_temp = $_FILES['logo']['tmp_name'];

                if(!in_array($logo_file_extension, $logo_allowed_extensions)) {
                    $_SESSION['error'][] = $this->language->global->error_message->invalid_file_type;
                }

                if(!is_writable(UPLOADS_PATH . 'store_logos/')) {
                    $_SESSION['error'][] = sprintf($this->language->global->error_message->directory_not_writable, UPLOADS_PATH . 'store_logos/');
                }

                if(empty($_SESSION['error'])) {

                    /* Delete current logo */
                    if(!empty($store->logo) && file_exists(UPLOADS_PATH . 'store_logos/' . $store->logo)) {
                        unlink(UPLOADS_PATH . 'store_logos/' . $store->logo);
                    }

                    /* Generate new name for logo */
                    $logo_new_name = md5(time() . rand()) . '.' . $logo_file_extension;

                    /* Upload the original */
                    move_uploaded_file($logo_file_temp, UPLOADS_PATH . 'store_logos/' . $logo_new_name);

                    /* Execute query */
                    Database::$database->query("UPDATE `stores` SET `logo` = '{$logo_new_name}' WHERE `store_id` = {$store->store_id}");

                }
            }

            /* Check for any errors on the favicon image */
            if($favicon) {
                $favicon_file_name = $_FILES['favicon']['name'];
                $favicon_file_extension = explode('.', $favicon_file_name);
                $favicon_file_extension = strtolower(end($favicon_file_extension));
                $favicon_file_temp = $_FILES['favicon']['tmp_name'];

                if(!in_array($favicon_file_extension, $favicon_allowed_extensions)) {
                    $_SESSION['error'][] = $this->language->global->error_message->invalid_file_type;
                }

                if(!is_writable(UPLOADS_PATH . 'store_favicons/')) {
                    $_SESSION['error'][] = sprintf($this->language->global->error_message->directory_not_writable, UPLOADS_PATH . 'store_favicons/');
                }

                if(empty($_SESSION['error'])) {

                    /* Delete current favicon */
                    if(!empty($store->favicon) && file_exists(UPLOADS_PATH . 'store_favicons/' . $store->favicon)) {
                        unlink(UPLOADS_PATH . 'store_favicons/' . $store->favicon);
                    }

                    /* Generate new name for favicon */
                    $favicon_new_name = md5(time() . rand()) . '.' . $favicon_file_extension;

                    /* Upload the original */
                    move_uploaded_file($favicon_file_temp, UPLOADS_PATH . 'store_favicons/' . $favicon_new_name);

                    /* Execute query */
                    Database::$database->query("UPDATE `stores` SET `favicon` = '{$favicon_new_name}' WHERE `store_id` = {$store->store_id}");

                }
            }

            /* Check for any errors on the image image */
            if($image) {
                $image_file_name = $_FILES['image']['name'];
                $image_file_extension = explode('.', $image_file_name);
                $image_file_extension = strtolower(end($image_file_extension));
                $image_file_temp = $_FILES['image']['tmp_name'];

                if(!in_array($image_file_extension, $image_allowed_extensions)) {
                    $_SESSION['error'][] = $this->language->global->error_message->invalid_file_type;
                }

                if(!is_writable(UPLOADS_PATH . 'store_images/')) {
                    $_SESSION['error'][] = sprintf($this->language->global->error_message->directory_not_writable, UPLOADS_PATH . 'store_images/');
                }

                if(empty($_SESSION['error'])) {

                    /* Delete current image */
                    if(!empty($store->image) && file_exists(UPLOADS_PATH . 'store_images/' . $store->image)) {
                        unlink(UPLOADS_PATH . 'store_images/' . $store->image);
                    }

                    /* Generate new name for image */
                    $image_new_name = md5(time() . rand()) . '.' . $image_file_extension;

                    /* Upload the original */
                    move_uploaded_file($image_file_temp, UPLOADS_PATH . 'store_images/' . $image_new_name);

                    /* Execute query */
                    Database::$database->query("UPDATE `stores` SET `image` = '{$image_new_name}' WHERE `store_id` = {$store->store_id}");

                }
            }

            if(empty($_SESSION['error'])) {
                $_POST['url'] = $_POST['url'] ? $_POST['url'] : string_generate(10);
                $details = json_encode([
                    'address' => $_POST['address'],
                    'phone' => $_POST['phone'],
                    'website' => $_POST['website'],
                    'email' => $_POST['email'],
                    'hours' => $hours
                ]);
                $socials = json_encode($_POST['socials']);
                $ordering = json_encode([
                    'on_premise_is_enabled' => $_POST['ordering_on_premise_is_enabled'],
                    'delivery_is_enabled' => $_POST['ordering_delivery_is_enabled'],
                    'takeaway_is_enabled' => $_POST['ordering_takeaway_is_enabled'],
                    'on_premise_minimum_value' => $_POST['ordering_on_premise_minimum_value'],
                    'delivery_minimum_value' => $_POST['ordering_delivery_minimum_value'],
                    'delivery_cost' => $_POST['ordering_delivery_cost'],
                    'delivery_free_minimum_value' => $_POST['ordering_delivery_free_minimum_value'],
                    'takeaway_minimum_value' => $_POST['ordering_takeaway_minimum_value'],
                ]);
                $paypal = json_encode([
                    'is_enabled' => $_POST['paypal_is_enabled'],
                    'mode' => $_POST['paypal_mode'],
                    'client_id' => $_POST['paypal_client_id'],
                    'secret' => $_POST['paypal_secret'],
                ]);
                $stripe = json_encode([
                    'is_enabled' => $_POST['stripe_is_enabled'],
                    'publishable_key' => $_POST['stripe_publishable_key'],
                    'secret_key' => $_POST['stripe_secret_key'],
                    'webhook_secret' => $_POST['stripe_webhook_secret'],
                ]);
                $offline_payment = json_encode([
                    'is_enabled' => $_POST['offline_payment_is_enabled'],
                ]);
                $business = json_encode([
                    'invoice_is_enabled' => $_POST['business_invoice_is_enabled'],
                    'invoice_nr_prefix' => $_POST['business_invoice_nr_prefix'],
                    'name' => $_POST['business_name'],
                    'address' => $_POST['business_address'],
                    'city' => $_POST['business_city'],
                    'county' => $_POST['business_county'],
                    'zip' => $_POST['business_zip'],
                    'country' => $_POST['business_country'],
                    'email' => $_POST['business_email'],
                    'phone' => $_POST['business_phone'],
                    'tax_type' => $_POST['business_tax_type'],
                    'tax_id' => $_POST['business_tax_id'],
                    'custom_key_one' => $_POST['business_custom_key_one'],
                    'custom_value_one' => $_POST['business_custom_value_one'],
                    'custom_key_two' => $_POST['business_custom_key_two'],
                    'custom_value_two' => $_POST['business_custom_value_two'],
                ]);

                if(!$_POST['url']) {
                    $is_existing_store = true;

                    /* Generate random url if not specified */
                    while($is_existing_store) {
                        $_POST['url'] = string_generate(10);

                        $domain_id_where = $_POST['domain_id'] ? "AND `domain_id` = {$_POST['domain_id']}" : "AND `domain_id` IS NULL";
                        $is_existing_store = $this->database->query("SELECT `store_id` FROM `stores` WHERE `url` = '{$_POST['url']}' {$domain_id_where}")->num_rows;
                    }

                }

                /* Prepare the statement and execute query */
                $stmt = Database::$database->prepare("
                    UPDATE 
                        `stores` 
                    SET 
                        `domain_id` = ?,
                        `url` = ?,
                        `name` = ?,
                        `title` = ?,
                        `description` = ?,
                        `details` = ?,
                        `socials` = ?,
                        `currency` = ?,
                        `password` = ?,
                        `timezone` = ?,
                        `custom_css` = ?,
                        `custom_js` = ?,
                        `is_se_visible` = ?,
                        `is_removed_branding` = ?,
                        `email_reports_is_enabled` = ?,
                        `email_orders_is_enabled` = ?,
                        `ordering` = ?,
                        `paypal` = ?,
                        `stripe` = ?,
                        `offline_payment` = ?,
                        `business` = ?,
                        `is_enabled` = ?,
                        `last_datetime` = ? 
                    WHERE 
                        `store_id` = ? 
                        AND `user_id` = ?
                  ");
                $stmt->bind_param(
                    'sssssssssssssssssssssssss',
                    $_POST['domain_id'],
                    $_POST['url'],
                    $_POST['name'],
                    $_POST['title'],
                    $_POST['description'],
                    $details,
                    $socials,
                    $_POST['currency'],
                    $_POST['password'],
                    $_POST['timezone'],
                    $_POST['custom_css'],
                    $_POST['custom_js'],
                    $_POST['is_se_visible'],
                    $_POST['is_removed_branding'],
                    $_POST['email_reports_is_enabled'],
                    $_POST['email_orders_is_enabled'],
                    $ordering,
                    $paypal,
                    $stripe,
                    $offline_payment,
                    $business,
                    $_POST['is_enabled'],
                    \Altum\Date::$date,
                    $store->store_id,
                    $this->user->user_id
                );
                $stmt->execute();
                $stmt->close();

                /* Update custom domain if needed */
                if($_POST['is_main_store']) {

                    $stmt = Database::$database->prepare("UPDATE `domains` SET `store_id` = ?, `last_datetime` = ? WHERE `domain_id` = ?");
                    $stmt->bind_param('sss', $store->store_id, \Altum\Date::$date, $_POST['domain_id']);
                    $stmt->execute();
                    $stmt->close();

                }

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('store_id=' . $store->store_id);

                $_SESSION['success'][] = $this->language->store_update->success_message;

                redirect('store-update/' . $store->store_id);
            }

        }

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
        Title::set(sprintf($this->language->store_update->title, $store->name));

        /* Prepare the View */
        $data = [
            'store' => $store,
            'domains' => $domains
        ];

        $view = new \Altum\Views\View('store-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
