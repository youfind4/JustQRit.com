<?php defined('ALTUMCODE') || die() ?>

<?= $this->views['header'] ?>

<?php require THEME_PATH . 'views/s/partials/ads_header.php' ?>

<div class="container mt-5">

    <nav aria-label="breadcrumb">
        <small>
            <ol class="custom-breadcrumbs">
                <li>
                    <a href="<?= $data->store->full_url ?>"><?= $this->language->s_store->breadcrumb ?></a> <div class="svg-sm text-muted d-inline-block"><?= include_view(ASSETS_PATH . '/images/s/chevron-right.svg') ?></div>
                </li>
                <li>
                    <a href="<?= $data->store->full_url . $data->menu->url ?>"><?= $data->menu->name ?></a> <div class="svg-sm text-muted d-inline-block"><?= include_view(ASSETS_PATH . '/images/s/chevron-right.svg') ?></div>
                </li>
                <li class="active" aria-current="page"><?= $data->category->name ?></li>
            </ol>
        </small>
    </nav>

    <h1 class="h3"><?= $data->category->name ?></h1>
    <p class="text-muted"><?= $data->category->description ?></p>

    <div class="row">
        <?php foreach($data->items as $item): ?>
            <div class="col-12 col-lg-6 my-3">
                <div class="d-flex position-relative h-100 rounded p-3 bg-gray-50">
                    <div class="store-item-image-wrapper mr-4">
                        <?php if(!empty($item->image)): ?>
                        <a href="<?= $data->store->full_url . $data->menu->url . '/' . $data->category->url . '/' . $item->url ?>">
                            <img src="<?= SITE_URL . UPLOADS_URL_PATH . 'item_images/' . $item->image ?>" class="store-item-image-background" loading="lazy" />
                        </a>
                        <?php endif ?>
                    </div>

                    <div class="d-flex flex-column justify-content-between w-100">
                        <div>
                            <h3 class="h5 mb-1">
                                <a href="<?= $data->store->full_url . $data->menu->url . '/' . $data->category->url . '/' . $item->url ?>">
                                    <?= $item->name ?>
                                </a>
                            </h3>

                            <p class="mt-1 text-muted"><?= string_truncate($item->description, 100) ?></p>
                        </div>

                        <div class="mt-3">
                            <div>
                                <span class="h5 text-black">
                                    <?= $item->price ?>
                                </span>
                                <span class="text-muted">
                                    <?= $data->store->currency ?>
                                </span>
                            </div>

                            <?php if($this->store->cart_is_enabled): ?>
                                <div class="mt-3">
                                    <?php if($item->variants_is_enabled): ?>
                                        <a href="<?= $data->store->full_url . $data->menu->url . '/' . $data->category->url . '/' . $item->url ?>" type="button" class="btn btn-block btn-sm btn-primary">
                                            <div class="svg-sm d-inline-block"><?= include_view(ASSETS_PATH . '/images/s/shopping-cart.svg') ?></div>
                                            <?= $this->language->s_item->configure ?>
                                        </a>
                                    <?php else: ?>
                                        <button
                                                type="button"
                                                class="add_to_cart btn btn-block btn-sm btn-primary"

                                                data-item-price="<?= $item->price ?>"
                                                data-item-id="<?= $item->item_id ?>"
                                                data-item-name="<?= $item->name ?>"
                                                data-item-full-url="<?= $data->store->full_url . $data->menu->url . '/' . $data->category->url . '/' . $item->url ?>"
                                                data-item-full-image="<?= $item->image ? SITE_URL . UPLOADS_URL_PATH . 'item_images/' . $item->image : null ?>"
                                        >

                                            <div class="add_to_cart_not_added">
                                                <div class="svg-sm d-inline-block"><?= include_view(ASSETS_PATH . '/images/s/shopping-cart.svg') ?></div>
                                                <?= $this->language->s_item->add_to_cart ?>
                                            </div>

                                            <div class="add_to_cart_added d-none">
                                                <div class="svg-sm d-inline-block"><?= include_view(ASSETS_PATH . '/images/s/check-circle.svg') ?></div>
                                                <?= $this->language->s_item->added_to_cart ?>
                                            </div>

                                        </button>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>

<?= include_view(THEME_PATH . 'views/s/partials/js_quick_add_to_cart.php', ['store' => $data->store]) ?>

<?= include_view(THEME_PATH . 'views/s/partials/share.php', ['external_url' => $data->store->full_url . $data->menu->url . '/' . $data->category->url]) ?>
