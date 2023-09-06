<?php

// Отключим редирект в записях потому что при /page/2 редиректит на /
add_filter( 'redirect_canonical', fn( $redirect_url ) => is_singular('city') ? false : $redirect_url );