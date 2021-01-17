<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
    <script src="<?= SITE_URL . ASSETS_URL_PATH . 'js/libraries/clipboard.min.js' ?>"></script>

    <script>
        'use strict';

        let clipboard = new ClipboardJS('[data-clipboard-text]');

        /* Copy full url handler */
        $('#url_copy').on('click', event => {
            let copy = event.currentTarget.dataset.copy;
            let copied = event.currentTarget.dataset.copied;

            $(event.currentTarget).attr('data-original-title', copied).tooltip('show');

            setTimeout(() => {
                $(event.currentTarget).attr('data-original-title', copy);
            }, 500);
        });
    </script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
