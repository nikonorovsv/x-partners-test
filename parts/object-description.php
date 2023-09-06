<?php

defined( 'ABSPATH' ) || exit;

global $post;

?>

<table class="table">
    <tbody>
        <tr>
            <th>Общая площадь</th>
            <td><?= get_field('area', $post->ID) ?> м<sup>2</sup></td>
        </tr>
        <tr>
            <th>Жилая площадь</th>
            <td><?= get_field('living_area', $post->ID) ?> м<sup>2</sup></td>
        </tr>
        <tr>
            <th>Этаж</th>
            <td><?= get_field('floor', $post->ID) ?></td>
        </tr>
    </tbody>
</table>
