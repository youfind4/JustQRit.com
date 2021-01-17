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
                    <a href="<?= url('store/' . $data->store->store_id) ?>"><?= $this->language->store->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?= url('orders/' . $data->store->store_id) ?>"><?= $this->language->orders->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <li class="active" aria-current="page"><?= $this->language->order->breadcrumb ?></li>
            </ol>
        </small>
    </nav>

    <h1 class="h4 text-truncate mr-3 mb-3"><?= sprintf($this->language->order->header, $data->order->order_number) ?></h1>

    <div class="card bg-gray-50">
        <div class="card-body">
            <div class="row">

                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-cog text-muted mr-1"></i> <?= $this->language->order->type ?>
                    </small>

                    <span>
                        <span class="badge badge-primary">
                            <?= $this->language->order->{'type_' . $data->order->type} ?>
                        </span>
                    </span>
                </div>

                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-stream text-muted mr-1"></i> <?= $this->language->order->status ?>
                    </small>

                    <span>
                        <?php if($data->order->status): ?>
                            <span class="badge badge-success">
                                <i class="fa fa-fw fa-sm fa-check mr-1"></i> <?= $this->language->order->status_complete ?>
                            </span>
                        <?php else: ?>
                            <span class="badge badge-warning">
                                <i class="fa fa-fw fa-sm fa-clock mr-1"></i> <?= $this->language->order->status_pending ?>
                            </span>
                        <?php endif ?>
                    </span>
                </div>

                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-list-ol text-muted mr-1"></i> <?= $this->language->order->ordered_items ?>
                    </small>

                    <span>
                        <?= nr($data->order->ordered_items) ?>
                    </span>
                </div>

                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-money-check-alt text-muted mr-1"></i> <?= $this->language->order->processor ?>
                    </small>

                    <span>
                        <?= $this->language->order->{'processor_' . $data->order->processor} ?>
                    </span>
                </div>

                <?php if(in_array($data->order->processor, ['stripe', 'paypal'])): ?>
                    <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                        <small class="text-muted font-weight-bold mb-2">
                            <i class="fa fa-fw fa-sm fa-dollar-sign text-muted mr-1"></i> <?= $this->language->order->is_paid ?>
                        </small>

                        <span>
                        <?php if($data->order->is_paid): ?>
                            <span class="badge badge-success">
                                <i class="fa fa-fw fa-sm fa-check mr-1"></i> <?= $this->language->global->yes ?>
                            </span>
                        <?php else: ?>
                            <span class="badge badge-warning">
                                <i class="fa fa-fw fa-sm fa-times mr-1"></i> <?= $this->language->global->no ?>
                            </span>
                        <?php endif ?>
                    </span>
                    </div>
                <?php endif ?>

                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-calendar text-muted mr-1"></i> <?= $this->language->order->datetime ?>
                    </small>

                    <span>
                        <?= \Altum\Date::get($data->order->datetime, 1) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card my-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-signature text-muted mr-1"></i> <?= $this->language->order->name ?>
                    </small>

                    <span>
                        <?= $data->order->details->name ?>
                    </span>
                </div>

                <?php if($data->order->type == 'on_premise'): ?>
                    <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                        <small class="text-muted font-weight-bold mb-2">
                            <i class="fa fa-fw fa-sm fa-sort-numeric-up-alt text-muted mr-1"></i> <?= $this->language->order->number ?>
                        </small>

                        <span>
                        <?= $data->order->details->number ?>
                    </span>
                    </div>
                <?php endif ?>

                <?php if($data->order->type == 'takeaway' || $data->order->type == 'delivery'): ?>
                    <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                        <small class="text-muted font-weight-bold mb-2">
                            <i class="fa fa-fw fa-sm fa-phone text-muted mr-1"></i> <?= $this->language->order->phone ?>
                        </small>

                        <span>
                        <?= $data->order->details->phone ?>
                    </span>
                    </div>
                <?php endif ?>

                <?php if($data->order->type == 'delivery'): ?>
                    <div class="col-12 col-lg-6 col-xl-4 d-flex flex-column mb-4">
                        <small class="text-muted font-weight-bold mb-2">
                            <i class="fa fa-fw fa-sm fa-map text-muted mr-1"></i> <?= $this->language->order->address ?>
                        </small>

                        <span>
                        <?= $data->order->details->address ?>
                    </span>
                    </div>
                <?php endif ?>

                <div class="col-12 d-flex flex-column">
                    <small class="text-muted font-weight-bold mb-2">
                        <i class="fa fa-fw fa-sm fa-paragraph text-muted mr-1"></i> <?= $this->language->order->message ?>
                    </small>

                    <span>
                        <?= $data->order->details->message ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5">
        <?php foreach($data->order_items as $order_item): ?>

            <div class="my-3 rounded p-3 bg-gray-50">
                <div class="row">
                    <div class="col-8 col-lg-6">
                        <div class="d-flex align-items-center">
                            <div class="order-item-image-wrapper mr-3">
                                <?php if($order_item->item_id && $order_item->data->image): ?>
                                    <img src="<?= SITE_URL . UPLOADS_URL_PATH . 'item_images/' . $order_item->data->image ?>" class="order-item-image-background" loading="lazy" />
                                <?php endif ?>
                            </div>

                            <div class="d-flex flex-column">
                                <div class="mr-3">
                                    <?php if($order_item->item_id): ?>
                                        <a href="<?= url('store-redirect?item_id=' . $order_item->item_id) ?>" class="font-weight-bold" target="_blank"><?= $order_item->data->name ?></a>
                                    <?php else: ?>
                                        <span class="font-weight-bold"><?= $order_item->data->name ?></span>
                                    <?php endif ?>
                                </div>


                                <div class="d-flex flex-column flex-lg-row">
                                    <div class="ml-lg-3 mb-3 mb-lg-0 mr-lg-3">
                                        <?php if(isset($order_item->data->variant_options)): ?>
                                            <?php foreach($order_item->data->variant_options as $variant_option): ?>
                                                <div>
                                                    <small class="text-muted">
                                                        &#8226; <span class="font-weight-bold"><?= $variant_option->name ?>:</span>
                                                        <?= $variant_option->value ?>
                                                    </small>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>

                                    <div>
                                        <?php if(isset($order_item->data->extras)): ?>
                                            <?php foreach($order_item->data->extras as $item_extra): ?>
                                                <div>
                                                    <small class="text-muted">&#8226; <?= $item_extra ?></small>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 d-flex flex-lg-column justify-content-lg-center order-1 order-lg-0 mt-3 mt-lg-0">
                        <div class="d-flex">
                            <span class="text-muted mr-3"><?= sprintf($this->language->order->quantity, nr($order_item->quantity)) ?></span>
                        </div>
                    </div>

                    <div class="col-4 col-lg-3 d-flex align-items-center justify-content-end order-0 order-lg-1">
                        <div>
                            <span class="font-weight-bold"><?= nr($order_item->price) ?></span> <span class="text-muted"><?= $data->store->currency ?></span>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach ?>

        <div class="d-flex justify-content-between bg-primary-100 p-3 rounded my-4">
            <div class="font-weight-bold">
                <?= $this->language->order->total ?>
            </div>

            <div>
                <span class="font-weight-bold"><?= nr($data->order->price) ?></span> <span class="text-muted"><?= $data->store->currency ?></span>
            </div>
        </div>

        <div class="my-4">
            <?php if(!$data->order->status): ?>
                <form method="post" role="form" action="<?= url('order/complete') ?>">
                    <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                    <input type="hidden" name="order_id" value="<?= $data->order->order_id ?>" />

                    <button type="submit" name="submit" class="btn btn-block btn-primary my-2"><?= $this->language->order->finish ?></button>
                </form>
            <?php endif ?>

            <form method="post" role="form" action="<?= url('order/delete') ?>">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                <input type="hidden" name="order_id" value="<?= $data->order->order_id ?>" />

                <button type="submit" name="submit" class="btn btn-block btn-outline-danger my-2"><?= $this->language->order->delete ?></button>
            </form>
        </div>
    </div>
</div>

