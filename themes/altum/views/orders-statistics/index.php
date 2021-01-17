<?php defined('ALTUMCODE') || die() ?>

<?php require THEME_PATH . 'views/partials/ads_header.php' ?>

<div class="container">
    <?php display_notifications() ?>

    <nav aria-label="breadcrumb">
        <small>
            <ol class="custom-breadcrumbs">
                <li>
                    <a href="<?= url('dashboard') ?>"><?= $this->language->dashboard->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?= url('store/' . $data->{$data->identifier_name}->store_id) ?>"><?= $this->language->store->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <?php if(in_array($data->identifier_name, ['menu', 'category', 'item'])): ?>
                    <li>
                        <a href="<?= url('menu/' . $data->{$data->identifier_name}->menu_id) ?>"><?= $this->language->menu->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                    </li>

                    <?php if(in_array($data->identifier_name, ['category', 'item'])): ?>
                        <li>
                            <a href="<?= url('category/' . $data->{$data->identifier_name}->category_id) ?>"><?= $this->language->category->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                        </li>
                    <?php endif ?>

                    <?php if(in_array($data->identifier_name, ['item'])): ?>
                        <li>
                            <a href="<?= url('item/' . $data->{$data->identifier_name}->item_id) ?>"><?= $this->language->item->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                        </li>
                    <?php endif ?>
                <?php endif ?>
                <li class="active" aria-current="page"><?= $this->language->orders_statistics->breadcrumb ?></li>
            </ol>
        </small>
    </nav>

    <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
        <div>
            <div>
                <h1 class="h4 text-truncate mr-3"><?= sprintf($this->language->orders_statistics->header, $data->{$data->identifier_name}->name) ?></h1>
            </div>

            <p>
                <a href="<?= $data->external_url ?>" target="_blank">
                    <img src="https://external-content.duckduckgo.com/ip3/<?= parse_url($data->external_url)['host'] ?>.ico" class="img-fluid icon-favicon mr-1" />

                    <?= $data->external_url ?>
                </a>

                <button
                        id="url_copy"
                        type="button"
                        class="btn btn-link"
                        data-toggle="tooltip"
                        title="<?= $this->language->global->clipboard_copy ?>"
                        aria-label="<?= $this->language->global->clipboard_copy ?>"
                        data-copy="<?= $this->language->global->clipboard_copy ?>"
                        data-copied="<?= $this->language->global->clipboard_copied ?>"
                        data-clipboard-text="<?= $data->external_url ?>"
                >
                    <i class="fa fa-fw fa-sm fa-copy"></i>
                </button>
            </p>
        </div>

        <div>
            <button
                    id="daterangepicker"
                    type="button"
                    class="btn btn-sm btn-outline-primary"
                    data-min-date="<?= \Altum\Date::get($data->{$data->identifier_name}->datetime, 4) ?>"
                    data-max-date="<?= \Altum\Date::get('', 4) ?>"
            >
                <i class="fa fa-fw fa-calendar mr-1"></i>
                <span>
                    <?php if($data->date->start_date == $data->date->end_date): ?>
                        <?= \Altum\Date::get($data->date->start_date, 2, \Altum\Date::$default_timezone) ?>
                    <?php else: ?>
                        <?= \Altum\Date::get($data->date->start_date, 2, \Altum\Date::$default_timezone) . ' - ' . \Altum\Date::get($data->date->end_date, 2, \Altum\Date::$default_timezone) ?>
                    <?php endif ?>
                </span>
                <i class="fa fa-fw fa-caret-down ml-1"></i>
            </button>
        </div>
    </div>

    <?php if(!count($data->orders_items)): ?>

        <div class="d-flex flex-column align-items-center justify-content-center">
            <img src="<?= SITE_URL . ASSETS_URL_PATH . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-5 mb-3" alt="<?= $this->language->orders_statistics->no_data ?>" />
            <h2 class="h4 text-muted mt-3"><?= $this->language->orders_statistics->no_data ?></h2>
            <p class="text-muted"><?= $this->language->orders_statistics->no_data_help ?></p>
        </div>

    <?php else: ?>

        <div class="chart-container mb-5">
            <canvas id="orders_items_chart"></canvas>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="h5"><?= $this->language->orders_statistics->ordered_items ?></h3>
                <p class="text-muted mb-3"><?= $this->language->orders_statistics->ordered_items_help ?></p>

                <?php foreach($data->orders_items as $row): ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                                <a href="<?= url('item/' . $row->item_id) ?>"><?= $row->name ?></a>
                            </div>

                            <div>
                                <small class="text-muted"><?= nr($row->value) . ' ' . $data->store->currency ?></small>
                                <span class="ml-3"><?= sprintf($this->language->orders_statistics->orders, nr($row->orders)) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

    <?php endif ?>

    <?php ob_start() ?>
    <link href="<?= SITE_URL . ASSETS_URL_PATH . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
    <?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

    <?php ob_start() ?>
    <script src="<?= SITE_URL . ASSETS_URL_PATH . 'js/libraries/Chart.bundle.min.js' ?>"></script>
    <script src="<?= SITE_URL . ASSETS_URL_PATH . 'js/libraries/moment.min.js' ?>"></script>
    <script src="<?= SITE_URL . ASSETS_URL_PATH . 'js/libraries/daterangepicker.min.js' ?>"></script>
    <script src="<?= SITE_URL . ASSETS_URL_PATH . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

    <script>
        'use strict';

        moment.tz.setDefault(<?= json_encode($this->user->timezone) ?>);

        /* Daterangepicker */
        $('#daterangepicker').daterangepicker({
            startDate: <?= json_encode($data->date->start_date) ?>,
            endDate: <?= json_encode($data->date->end_date) ?>,
            minDate: $('#daterangepicker').data('min-date'),
            maxDate: $('#daterangepicker').data('max-date'),
            ranges: {
                <?= json_encode($this->language->global->date->today) ?>: [moment(), moment()],
                <?= json_encode($this->language->global->date->yesterday) ?>: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                <?= json_encode($this->language->global->date->last_7_days) ?>: [moment().subtract(6, 'days'), moment()],
                <?= json_encode($this->language->global->date->last_30_days) ?>: [moment().subtract(29, 'days'), moment()],
                <?= json_encode($this->language->global->date->this_month) ?>: [moment().startOf('month'), moment().endOf('month')],
                <?= json_encode($this->language->global->date->last_month) ?>: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            singleCalendar: true,
            locale: <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>,
        }, (start, end, label) => {

            /* Redirect */
            redirect(`<?= url('statistics?' . $data->identifier_key . '=' . $data->identifier_value . '&type=' . $data->type) ?>&start_date=${start.format('YYYY-MM-DD')}&end_date=${end.format('YYYY-MM-DD')}`, true);

        });

        <?php if(count($data->orders_items)): ?>
        /* Default chart options */
        Chart.defaults.global.elements.line.borderWidth = 4;
        Chart.defaults.global.elements.point.radius = 3;
        Chart.defaults.global.elements.point.borderWidth = 6;

        let chart_options = {
            elements: {
                line: {
                    tension: 0
                }
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: (tooltipItem, data) => {
                        let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                        return `${nr(value)} - ${data.datasets[tooltipItem.datasetIndex].label}`;
                    }
                }
            },
            legend: {
                display: false
            },
            title: {
                text: '',
                display: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        beginAtZero: true,
                        userCallback: (value, index, values) => {
                            if (Math.floor(value) === value) {
                                return nr(value);
                            }
                        },
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        callback: (tick, index, array) => {
                            return index % 2 ? '' : tick;
                        }
                    }
                }]
            },
            responsive: true,
            maintainAspectRatio: false
        };

        let css = window.getComputedStyle(document.body)

        /* Orders chart */
        let orders_items_chart = document.getElementById('orders_items_chart').getContext('2d');

        let value_color = css.getPropertyValue('--primary');
        let value_gradient = orders_items_chart.createLinearGradient(0, 0, 0, 250);
        value_gradient.addColorStop(0, 'rgba(102, 127, 234, .1)');
        value_gradient.addColorStop(1, 'rgba(102, 127, 234, 0.025)');

        let orders_color = css.getPropertyValue('--gray-800');
        let orders_gradient = orders_items_chart.createLinearGradient(0, 0, 0, 250);
        orders_gradient.addColorStop(0, 'rgba(37, 45, 60, .1)');
        orders_gradient.addColorStop(1, 'rgba(37, 45, 60, 0.025)');

        /* Display chart */
        new Chart(orders_items_chart, {
            type: 'line',
            data: {
                labels: <?= $data->orders_items_chart['labels'] ?>,
                datasets: [
                    {
                        label: <?= json_encode($this->language->orders_statistics->ordered_items_label) ?>,
                        data: <?= $data->orders_items_chart['ordered_items'] ?? '[]' ?>,
                        backgroundColor: orders_gradient,
                        borderColor: orders_color,
                        fill: true
                    },
                    {
                        label: <?= json_encode($this->language->orders_statistics->value_label) ?>,
                        data: <?= $data->orders_items_chart['value'] ?? '[]' ?>,
                        backgroundColor: value_gradient,
                        borderColor: value_color,
                        fill: true
                    }
                ]
            },
            options: chart_options
        });
        <?php endif ?>
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
</div>

<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>


