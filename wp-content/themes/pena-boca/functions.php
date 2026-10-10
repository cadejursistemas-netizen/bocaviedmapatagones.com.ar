<?php
// Evitar acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function pboca_configuracion_tema() {
    // Soporte para etiquetas de título automáticas
    add_theme_support( 'title-tag' );

    // Soporte para imágenes destacadas (thumbnails)
    add_theme_support( 'post-thumbnails' );

    // Registrar el menú de navegación principal
    register_nav_menus( array(
        'menu_principal' => 'Menú Principal (Cabecera)',
    ) );
}
add_action( 'after_setup_theme', 'pboca_configuracion_tema' );

function pboca_cargar_scripts() {
    // Cargar la hoja de estilos principal (style.css)
    wp_enqueue_style( 'pboca-style', get_stylesheet_uri(), array(), '1.0' );
    
    // Tipografías alojadas en el propio tema (Montserrat y Russo One): sin pedidos a Google
    wp_enqueue_style( 'pboca-fonts', get_template_directory_uri() . '/fonts/fonts.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'pboca_cargar_scripts' );

// Precargar las fuentes principales para que el texto aparezca más rápido
function pboca_precargar_fuentes() {
    $base = get_template_directory_uri() . '/fonts/';
    foreach ( array( 'montserrat-latin.woff2', 'russo-one-latin.woff2' ) as $f ) {
        echo '<link rel="preload" href="' . esc_url( $base . $f ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
}
add_action( 'wp_head', 'pboca_precargar_fuentes', 1 );

// Ícono de la pestaña (favicon) con el escudo de la peña
function pboca_favicon() {
    $base = get_template_directory_uri() . '/icons/';
    echo '<link rel="icon" href="' . esc_url( $base . 'favicon.ico' ) . '" sizes="any">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $base . 'favicon-32.png' ) . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="192x192" href="' . esc_url( $base . 'icon-192.png' ) . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url( $base . 'apple-touch-icon.png' ) . '">' . "\n";
    echo '<meta name="theme-color" content="#0a1122">' . "\n";
}
add_action( 'wp_head', 'pboca_favicon', 2 );
