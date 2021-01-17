<?php
if(
    !empty($this->settings->ads->header_restaurant)
    && !$this->store_user->plan_settings->no_ads
): ?>
    <div class="container my-3"><?= $this->settings->ads->header_restaurant ?></div>
<?php endif ?>
