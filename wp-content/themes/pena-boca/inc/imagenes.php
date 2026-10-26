<?php
/**
 * URL de un archivo del tema con la fecha del archivo como "versión".
 * Cuando el archivo cambia, la dirección cambia (?v=...) y el navegador y Cloudflare
 * vuelven a bajarlo, en lugar de mostrar la copia vieja guardada.
 *
 * Uso: <?php echo pboca_img( 'images/mod-viajes.webp' ); ?>
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function pboca_img( $ruta ) {
    $ruta = ltrim( $ruta, '/' );
    $url  = get_template_directory_uri() . '/' . $ruta;
    $file = get_template_directory() . '/' . $ruta;
    if ( file_exists( $file ) ) {
        $url = add_query_arg( 'v', filemtime( $file ), $url );
    }
    return $url;
}
