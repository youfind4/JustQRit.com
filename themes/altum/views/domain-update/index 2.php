<?php defined('ALTUMCODE') || die() ?>

<?php require THEME_PATH . 'views/partials/ads_header.php' ?>

<div class="container">
    <?php display_notifications() ?>

    <nav aria-label="breadcrumb">
        <small>
            <ol class="custom-breadcrumbs">
                <li>
                    <a href="<?= url('domains') ?>"><?= $this->language->domains->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <li class="active" aria-current="page"><?= $this->language->domain_update->breadcrumb ?></li>
            </ol>
        </small>
    </nav>

    <?php $url = parse_url(SITE_URL); $host = $url['host'] . (strlen($url['path']) > 1 ? $url['path'] : null); ?>

    <div class="d-flex align-items-center">
        <h1 class="h4 text-truncate mr-2"><?= $this->language->domain_update->header ?></h1>

        <?= include_view(THEME_PATH . 'views/domains/domain_dropdown_button.php', ['id' => $data->domain->domain_id]) ?>
    </div>
    <p class="text-muted"><?= sprintf($this->language->domains->input->help, '<strong>' . $_SERVER['SERVER_ADDR'] . '</strong>', '<strong>' . $host . '</strong>') ?></p>

    <form action="" method="post" role="form">
        <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

        <div class="form-group">
            <label for="host"><i class="fa fa-fw fa-globe fa-sm text-muted mr-1"></i> <?= $this->language->domains->input->host ?></label>
            <input type="text" id="host" name="host" class="form-control" value="<?= $data->domain->host ?>" placeholder="<?= $this->language->domains->input->host_placeholder ?>" required="required" />
        </div>

        <div class="form-group">
            <label for="custom_index_url"><i class="fa fa-fw fa-sitemap fa-sm text-muted mr-1"></i> <?= $this->language->domains->input->custom_index_url ?></label>
            <input type="text" id="custom_index_url" name="custom_index_url" class="form-control" value="<?= $data->domain->custom_index_url ?>" placeholder="<?= $this->language->domains->input->custom_index_url_placeholder ?>" />
            <small class="form-text text-muted"><?= $this->language->domains->input->custom_index_url_help ?></small>
        </div>

        <button type="submit" name="submit" class="btn btn-block btn-primary"><?= $this->language->global->update ?></button>
    </form>

</div>
