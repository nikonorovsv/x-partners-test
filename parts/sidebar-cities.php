<?php

defined( 'ABSPATH' ) || exit;

$cities = get_cities();

?>

<div class="card mb-4 bg-success text-white">
    <div class="card-body">
        <h5 class="card-title font-weight-bold">
            Другие города
        </h5>
        <div class="card-text">
            <ul class="list-unstyled">
                <?php foreach ($cities as $city) { ?>
                    <li>
                        <a href="<?= $city['url'] ?>" class="text-white">
                            <?= $city['name'] ?> (<?= $city['count'] ?>)
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>


