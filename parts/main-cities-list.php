<?php

defined( 'ABSPATH' ) || exit;

$cities = get_cities();

?>

<div class="row">
    <?php

    foreach ($cities as $city) { ?>

        <div class="col-md-2 col-sm-4">
            <?= render( 'city-card', $city ) ?>
        </div>

        <?php
    } ?>
</div>


