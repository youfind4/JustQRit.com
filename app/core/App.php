<?php

namespace Altum;

use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Models\Store;
use Altum\Models\Plan;
use Altum\Models\User;
use Altum\Models\Website;
use \Altum\Routing\Router;
use \Altum\Models\Settings;

class App {

    protected $database;

    public function __construct() {

        /* Connect to the database */
        $this->database = Database\Database::initialize();

        /* Initialize caching system */
        Cache::initialize();

        /* Initiate the Language system */
        Language::initialize(APP_PATH . 'languages/');

        /* Parse the URL parameters */
        Router::parse_url();

        /* Parse the potential language url */
        Router::parse_language();

        /* Handle the controller */
        Router::parse_controller();

        /* Create a new instance of the controller */
        $controller = Router::get_controller(Router::$controller, Router::$path);

        /* Process the method and get it */
        $method = Router::parse_method($controller);

        /* Get the remaining params */
        $params = Router::get_params();

        /* Connect to the database */
        $this->database = \Altum\Database\Database::initialize();

        /* Get the website settings */
        $settings = (new Settings())->get();

        /* Initiate the Language system with the default language */
        Language::set_default($settings->default_language);

        /* Set the default theme style */
        ThemeStyle::set_default($settings->default_theme_style);

        /* Initiate the Title system */
        Title::initialize($settings->title);
        Meta::initialize();

        /* Set the date timezone */
        date_default_timezone_set(Date::$default_timezone);
        Date::$timezone = date_default_timezone_get();

        /* Setting the datetime for backend usages ( insertions in database..etc ) */
        Date::$date = Date::get();

        /* Check for a potential logged in account and do some extra checks */
        if(Authentication::check()) {

            $user = Authentication::$user;

            if(!$user) {
                Authentication::logout();
            }

            $user_id = Authentication::$user_id;

            /* Determine if the current plan is expired or disabled */
            $user->plan_is_expired = false;

            /* Get current plan proper details */
            $user->plan = (new Plan(['settings' => $settings]))->get_plan_by_id($user->plan_id);

            /* Check if its a custom plan */
            if($user->plan->plan_id == 'custom') {
                $user->plan->settings = $user->plan_settings;
            }

            if(!$user->plan || ($user->plan && ((new \DateTime()) > (new \DateTime($user->plan_expiration_date)) && $user->plan_id != 'free') || !$user->plan->status)) {
                $user->plan_is_expired = true;

                /* If the free plan is available, give it to the user */
                if($settings->plan_free->status) {
                    $plan_settings = json_encode($settings->plan_free->settings);

                    $this->database->query("UPDATE `users` SET `plan_id` = 'free', `plan_settings` = '{$plan_settings}' WHERE `user_id` = {$user_id}");
                }

                /* Make sure we delete the subscription_id if any */
                if($user->payment_subscription_id) {
                    $this->database->query("UPDATE `users` SET `payment_subscription_id` = '' WHERE `user_id` = {$user_id}");
                }

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user_id);

                /* Make sure to redirect the person to the payment page and only let the person access the following pages */
                if(!in_array(Router::$controller_key, ['plan', 'pay', 'account', 'account-plan', 'account-payments', 'account-logs', 'logout']) && Router::$path != 'admin') {
                    redirect('plan/new');
                }
            }

            /* Update last activity */
            if(!$user->last_activity || (new \DateTime($user->last_activity))->modify('+5 minutes') < (new \DateTime())) {
                (new User())->update_last_activity(Authentication::$user_id);
            }

            /* Update the language of the site for next page use if the current language (default) is different than the one the user has */
            if(!isset($_GET['set_language']) && Language::$language != $user->language) {
                Language::set_by_name($user->language);
            }

            /* Update the language of the user if needed */
            if(isset($_GET['set_language']) && in_array($_GET['set_language'], Language::$languages)) {
                $_GET['set_language'] = \Altum\Database\Database::clean_string($_GET['set_language']);

                $this->database->query("UPDATE `users` SET `language` = '{$_GET['set_language']}' WHERE `user_id` = {$user_id}");

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user_id);
            }

            /* Set the timezone to be used for displaying */
            Date::$timezone = $user->timezone;

            /* Store all the details of the user in the Authentication static class as well */
            Authentication::$user = $user;
        }


        /* Set a CSRF Token */
        Csrf::set('token');
        Csrf::set('global_token');

        /* If the language code is the default one, redirect to index */
        if(Router::$language_code == Language::$default_language_code) {
            redirect(Router::$original_request);
        }

        /* Get the needed language strings */
        $language = Language::get();

        /* Add main vars inside of the controller */
        $controller->add_params([
            'database'  => $this->database,
            'params'    => $params,
            'settings'  => $settings,
            'language'  => $language,

            /* Potential logged in user */
            'user'      => Authentication::$user
        ]);

        /* Call the controller method */
        call_user_func_array([ $controller, $method ], []);

        /* Render and output everything */
        $controller->run();

        /* Close database */
        Database\Database::close();
    }

}
