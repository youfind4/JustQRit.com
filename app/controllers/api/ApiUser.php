<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Response;
use Altum\Traits\Apiable;

class ApiUser extends Controller {
    use Apiable;

    public function index() {

        $this->verify_request();

        /* Decide what to continue with */
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->get();
            break;
        }

        $this->return_404();
    }

    public function get() {

        /* Prepare the data */
        $data = [
            'type' => 'users',
            'id' => $this->api_user->user_id,

            'email' => $this->api_user->email,
            'billing' => json_decode($this->api_user->billing),
            'is_enabled' => (bool) $this->api_user->active,
            'plan_id' => $this->api_user->plan_id,
            'plan_expiration_date' => $this->api_user->plan_expiration_date,
            'plan_settings' => $this->api_user->plan_settings,
            'plan_trial_done' => (bool) $this->api_user->plan_trial_done,
            'language' => $this->api_user->language,
            'timezone' => $this->api_user->timezone,
            'country' => $this->api_user->country,
            'date' => $this->api_user->date,
            'last_activity' => $this->api_user->last_activity,
            'total_logins' => (int) $this->api_user->total_logins,
        ];

        Response::jsonapi_success($data);
    }
}
