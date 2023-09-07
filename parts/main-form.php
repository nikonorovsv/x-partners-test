<?php

defined( 'ABSPATH' ) || exit;

// Декларируем параметры
extract([
    'nonce' => null
], EXTR_SKIP);

?>

<div class="card bg-light">
    <div class="card-body">
        <?php

        // Удобная обертка для <div data-component="FormAddRealEstateObject">
        // чтобы не городить вермишель с пропсами
        the_vue_app([
            'name'  => 'FormAddRealEstateObject',
            'props' => [
                'nonce'  => $nonce,
                'author' => get_current_user_id()
            ],
        ]); ?>
    </div>
</div>

